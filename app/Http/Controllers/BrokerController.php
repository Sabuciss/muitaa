<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Documents;
use Illuminate\Http\Request;

class BrokerController extends Controller
{
    public function index()
    {
        $json = json_decode(file_get_contents('https://deskplan.lv/muita/app.json'), true);
        $cases = $json['cases'] ?? [];
        $documents = Documents::all()->toArray();
        
        return view('broker.dashboard', [
            'cases' => $cases,
            'documents' => $documents,
            'totals' => $json['total'] ?? null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['case_id' => 'required', 'filename' => 'required']);

        Documents::create([
            'id' => 'doc-' . uniqid(),
            ...$request->only(['case_id', 'category', 'filename', 'mime_type', 'pages']),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('broker.index')->with('status', 'Document saved.');
    }

    public function createDocument()
    {
        return view('documents.create');
    }

    public function storeDocument(Request $request)
    {
        $request->validate([
            'case_id' => 'required',
            'filename' => 'required',
            'category' => 'nullable',
        ]);

        Documents::create([
            'id' => 'doc-' . uniqid(),
            'case_id' => $request->case_id,
            'filename' => $request->filename,
            'category' => $request->category,
            'mime_type' => $request->mime_type,
            'pages' => $request->pages,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Document uploaded successfully.');
    }

    public function editDocument($id)
    {
        $document = Documents::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    public function updateDocument(Request $request, $id)
    {
        $document = Documents::findOrFail($id);
        $request->validate([
            'filename' => 'required',
            'category' => 'nullable',
        ]);

        $document->update($request->only(['filename', 'category', 'mime_type', 'pages']));
        return redirect()->route('dashboard')->with('status', 'Document updated successfully.');
    }

    public function deleteDocument($id)
    {
        Documents::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('status', 'Document deleted successfully.');
    }
}

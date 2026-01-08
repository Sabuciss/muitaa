<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Documents;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['documents'] as $documents) {
            Documents::create([
                'id' => $documents['id'],
                'case_id' => $documents['case_id'],
                'filename' => $documents['filename'],
                'mime_type' => $documents['mime_type'],
                'category' => $documents['category'],
                'pages' => $documents['pages'],
                'uploaded_by' => $documents['uploaded_by'],
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicles;

class VehiclesController extends Controller
{
    public function index()
    {
        $vehicles = Vehicles::orderBy('plate_no')->get();
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|string|unique:vehicles,id',
            'plate_no' => 'required|string|max:50',
            'country' => 'nullable|string|max:10',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'vin' => 'nullable|string|max:100',
        ]);

        Vehicles::create($data);
        return redirect()->route('vehicles.index')->with('status', 'Vehicle created');
    }

    public function edit($id)
    {
        $vehicle = Vehicles::findOrFail($id);
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicles::findOrFail($id);
        $data = $request->validate([
            'plate_no' => 'required|string|max:50',
            'country' => 'nullable|string|max:10',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'vin' => 'nullable|string|max:100',
        ]);

        $vehicle->update($data);
        return redirect()->route('vehicles.index')->with('status', 'Vehicle updated');
    }

    public function destroy($id)
    {
        $vehicle = Vehicles::findOrFail($id);
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('status', 'Vehicle deleted');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehiclesController extends Controller
{

    public function showDataFromJson()
    {
    $data = file_get_contents("https://deskplan.lv/muita/app.json");
    $jsonData = json_decode($data, true);

    return view('/', ['jsonData' => $jsonData]);
    }

        public function updateVehiclesFromJson($jsonData)
    {
        foreach ($jsonData['vehicles'] as $vehicle) {
            \App\Models\Vehicle::updateOrCreate(
                ['id' => $vehicle['id']],
                [
                    'plate_no' => $vehicle['plate_no'],
                    'country' => $vehicle['country'],
                    'make' => $vehicle['make'],
                    'model' => $vehicle['model'],
                    'vin' => $vehicle['vin'],
                ]
            );
        }
    }
}
@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Vehicle</h1>

    @if($errors->any())
        <div class="mb-3 text-red-600">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" class="space-y-3 max-w-lg">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm">ID</label>
            <input name="id" class="w-full border px-2 py-1" value="{{ $vehicle->id }}" disabled />
        </div>
        <div>
            <label class="block text-sm">Plate No</label>
            <input name="plate_no" class="w-full border px-2 py-1" value="{{ old('plate_no', $vehicle->plate_no) }}" required />
        </div>
        <div>
            <label class="block text-sm">Country</label>
            <input name="country" class="w-full border px-2 py-1" value="{{ old('country', $vehicle->country) }}" />
        </div>
        <div>
            <label class="block text-sm">Make</label>
            <input name="make" class="w-full border px-2 py-1" value="{{ old('make', $vehicle->make) }}" />
        </div>
        <div>
            <label class="block text-sm">Model</label>
            <input name="model" class="w-full border px-2 py-1" value="{{ old('model', $vehicle->model) }}" />
        </div>
        <div>
            <label class="block text-sm">VIN</label>
            <input name="vin" class="w-full border px-2 py-1" value="{{ old('vin', $vehicle->vin) }}" />
        </div>
        <div>
            <button class="px-3 py-2 bg-green-600 text-white rounded">Save</button>
            <a href="{{ route('vehicles.index') }}" class="ml-2 text-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection

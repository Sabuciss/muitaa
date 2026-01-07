@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Vehicles</h1>
        <a href="{{ route('vehicles.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">New Vehicle</a>
    </div>

    @if(session('status'))
        <div class="mb-3 text-green-600">{{ session('status') }}</div>
    @endif

    <table class="min-w-full text-sm bg-white shadow rounded">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-3 py-2">ID</th>
                <th class="px-3 py-2">Plate</th>
                <th class="px-3 py-2">Country</th>
                <th class="px-3 py-2">Make</th>
                <th class="px-3 py-2">Model</th>
                <th class="px-3 py-2">VIN</th>
                <th class="px-3 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $v)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $v->id }}</td>
                    <td class="px-3 py-2">{{ $v->plate_no }}</td>
                    <td class="px-3 py-2">{{ $v->country }}</td>
                    <td class="px-3 py-2">{{ $v->make }}</td>
                    <td class="px-3 py-2">{{ $v->model }}</td>
                    <td class="px-3 py-2">{{ $v->vin }}</td>
                    <td class="px-3 py-2">
                        <a href="{{ route('vehicles.edit', $v->id) }}" class="text-blue-600 mr-2">Edit</a>
                        <form action="{{ route('vehicles.destroy', $v->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Delete vehicle?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

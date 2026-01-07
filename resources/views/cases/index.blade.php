<x-app-layout>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-bold">Cases</h1>
            <a href="{{ route('cases.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">New Case</a>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif

        <table class="min-w-full text-sm bg-white rounded shadow overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Vehicle</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left">Priority</th>
                    <th class="p-2 text-left">Arrival</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cases as $c)
                    <tr class="border-t">
                        <td class="p-2">{{ $c->id }}</td>
                        <td class="p-2">{{ $c->vehicle_id ?? '' }}</td>
                        <td class="p-2">{{ $c->status ?? '' }}</td>
                        <td class="p-2">{{ $c->priority ?? '' }}</td>
                        <td class="p-2">{{ $c->arrival_ts ?? '' }}</td>
                        <td class="p-2">
                            <a href="{{ route('cases.edit', $c->id) }}" class="text-blue-600 mr-2">Edit</a>
                            <form action="{{ route('cases.destroy', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this case?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Case</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cases.update', $case->id) }}" method="POST" class="space-y-4 max-w-2xl">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Case ID (Read-only)</label>
                <input type="text" value="{{ $case->id }}" disabled class="w-full border border-gray-300 px-3 py-2 rounded bg-gray-100" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">External Reference</label>
                <input type="text" name="external_ref" value="{{ old('external_ref', $case->external_ref) }}" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Optional external reference" />
                @error('external_ref') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Vehicle ID</label>
                <input type="text" name="vehicle_id" value="{{ old('vehicle_id', $case->vehicle_id) }}" class="w-full border border-gray-300 px-3 py-2 rounded" placeholder="Optional vehicle ID" />
                @error('vehicle_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 px-3 py-2 rounded">
                    <option value="">Select status</option>
                    <option value="pending" {{ old('status', $case->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $case->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ old('status', $case->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="closed" {{ old('status', $case->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Priority</label>
                <select name="priority" class="w-full border border-gray-300 px-3 py-2 rounded">
                    <option value="">Select priority</option>
                    <option value="low" {{ old('priority', $case->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $case->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $case->priority) == 'high' ? 'selected' : '' }}>High</option>
                    <option value="critical" {{ old('priority', $case->priority) == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
                @error('priority') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Arrival Time</label>
                <input type="datetime-local" name="arrival_ts" value="{{ old('arrival_ts', $case->arrival_ts) }}" class="w-full border border-gray-300 px-3 py-2 rounded" />
                @error('arrival_ts') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Case</button>
                <a href="{{ route('cases.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>

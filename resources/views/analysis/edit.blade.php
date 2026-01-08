<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Edit Risk Analysis</h1>

            <form action="{{ route('analysis.update', $analysis->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Case ID</label>
                    <input type="text" value="{{ $analysis->case_id }}" class="w-full border rounded px-2 py-1 text-sm bg-gray-100" disabled>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Risk Level *</label>
                    <?php $data = json_decode($analysis->checks, true) ?? []; ?>
                    <select name="risk_level" class="w-full border rounded px-2 py-1 text-sm" required>
                        <option {{ ($data['risk_level'] ?? '') === 'Low' ? 'selected' : '' }}>Low</option>
                        <option {{ ($data['risk_level'] ?? '') === 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option {{ ($data['risk_level'] ?? '') === 'High' ? 'selected' : '' }}>High</option>
                        <option {{ ($data['risk_level'] ?? '') === 'Critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Findings</label>
                    <textarea name="findings" class="w-full border rounded px-2 py-1 text-sm" rows="4">{{ $data['findings'] ?? '' }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded">Update</button>
                    <form action="{{ route('analysis.delete', $analysis->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                    </form>
                    <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-gray-300 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

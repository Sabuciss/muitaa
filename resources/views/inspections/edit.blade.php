<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Inspection</h1>

            <form action="{{ route('inspections.update', $inspection->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Case ID</label>
                    <input type="text" value="{{ $inspection->case_id }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100" disabled>
                    <p class="text-xs text-gray-500 mt-1">Case ID cannot be changed</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Inspection Type *</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('type') border-red-500 @enderror" required>
                        <option value="physical" {{ $inspection->type === 'physical' ? 'selected' : '' }}>Physical Inspection</option>
                        <option value="document" {{ $inspection->type === 'document' ? 'selected' : '' }}>Document Review</option>
                        <option value="scanner" {{ $inspection->type === 'scanner' ? 'selected' : '' }}>Scanner Screening</option>
                        <option value="canine" {{ $inspection->type === 'canine' ? 'selected' : '' }}>Canine Detection</option>
                        <option value="lab" {{ $inspection->type === 'lab' ? 'selected' : '' }}>Laboratory Analysis</option>
                        <option value="other" {{ $inspection->type === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Inspection Location *</label>
                    <input type="text" name="location" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('location') border-red-500 @enderror" value="{{ old('location', $inspection->location) }}" required>
                    @error('location')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Inspection Date *</label>
                    <input type="date" name="start_ts" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('start_ts') border-red-500 @enderror" value="{{ old('start_ts', $inspection->start_ts ? substr($inspection->start_ts, 0, 10) : '') }}" required>
                    @error('start_ts')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Checks Performed</label>
                    <textarea name="checks" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" rows="3" placeholder="Enter checks separated by commas">{{ old('checks', $inspection->checks ? implode(', ', json_decode($inspection->checks, true) ?? []) : '') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Separate multiple items with commas</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Decision *</label>
                    <select name="decision" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('decision') border-red-500 @enderror" required>
                        <option value="approved">Approved - Clear to Proceed</option>
                        <option value="rejected">Rejected - Goods Seized</option>
                        <option value="pending">Pending - Further Review Required</option>
                    </select>
                    @error('decision')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Update Inspection
                    </button>
                    <form action="{{ route('inspections.delete', $inspection->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this inspection?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete Inspection
                        </button>
                    </form>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

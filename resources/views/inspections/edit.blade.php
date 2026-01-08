<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Inspection</h1>

            <form action="{{ route('inspections.update', $inspection->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Case ID</label>
                    <input type="text" value="{{ $inspection->case_id }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100" disabled>
                    <p class="text-xs text-gray-500 mt-1">Case ID cannot be changed</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Inspection Type *</label>
                    <select name="type" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('type') border-red-500 @enderror" required>
                        <option value="dokumentu" {{ $inspection->type === 'dokumentu' ? 'selected' : '' }}>Document</option>
                        <option value="fiziska" {{ $inspection->type === 'fiziska' ? 'selected' : '' }}>Physical</option>
                        <option value="RTG" {{ $inspection->type === 'RTG' ? 'selected' : '' }}>X-Ray</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Risk Level *</label>
                    <select name="risk_level" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('risk_level') border-red-500 @enderror" required>
                        <option value="">-- Select Risk Level --</option>
                        <option value="Low" {{ $inspection->risk_level === 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ $inspection->risk_level === 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $inspection->risk_level === 'High' ? 'selected' : '' }}>High</option>
                        <option value="Very High" {{ $inspection->risk_level === 'Very High' ? 'selected' : '' }}>Very High</option>
                        <option value="Critical" {{ $inspection->risk_level === 'Critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                    @error('risk_level')
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Decision</label>
                    <select name="decision" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('decision') border-red-500 @enderror">
                        <option value="">-- No Decision --</option>
                        <option value="released" {{ $inspection->decision === 'released' ? 'selected' : '' }}>Released</option>
                        <option value="hold" {{ $inspection->decision === 'hold' ? 'selected' : '' }}>Hold</option>
                        <option value="reject" {{ $inspection->decision === 'reject' ? 'selected' : '' }}>Reject</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Comments</label>
                    <textarea name="comments" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" rows="2" placeholder="Add comments...">{{ old('comments', $inspection->comments) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Justifications</label>
                    <textarea name="justifications" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" rows="2" placeholder="Add justifications...">{{ old('justifications', $inspection->justifications) }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Update Inspection
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

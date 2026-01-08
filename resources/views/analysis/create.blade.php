<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Create Risk Analysis</h1>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('analysis.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Case ID *</label>
                    <input type="text" name="case_id" value="{{ old('case_id') }}" class="w-full border rounded px-2 py-1 text-sm @error('case_id') border-red-500 @enderror" required>
                    @error('case_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Risk Level *</label>
                    <select name="risk_level" class="w-full border rounded px-2 py-1 text-sm @error('risk_level') border-red-500 @enderror" required>
                        <option value="">-- Select Risk Level --</option>
                        <option value="Low" @selected(old('risk_level') === 'Low')>Low</option>
                        <option value="Medium" @selected(old('risk_level') === 'Medium')>Medium</option>
                        <option value="High" @selected(old('risk_level') === 'High')>High</option>
                        <option value="Critical" @selected(old('risk_level') === 'Critical')>Critical</option>
                    </select>
                    @error('risk_level')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Findings</label>
                    <textarea name="findings" class="w-full border rounded px-2 py-1 text-sm" rows="4" placeholder="Risk analysis findings and observations">{{ old('findings') }}</textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Create Analysis</button>
                    <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

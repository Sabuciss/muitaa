<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Create Inspection</h1>

            <form action="{{ route('inspections.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Case ID *</label>
                    <input type="text" name="case_id" class="w-full border rounded px-2 py-1 text-sm" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Type *</label>
                    <select name="type" class="w-full border rounded px-2 py-1 text-sm" required>
                        <option value="">-- Select Type --</option>
                        <option value="dokumentu">Document</option>
                        <option value="fiziska">Physical</option>
                        <option value="RTG">X-Ray</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Location</label>
                    <input type="text" name="location" class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Date</label>
                    <input type="date" name="start_ts" class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Checks</label>
                    <input type="text" name="checks" class="w-full border rounded px-2 py-1 text-sm" placeholder="Comma separated">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Risk Level *</label>
                    <select name="risk_level" class="w-full border rounded px-2 py-1 text-sm" required>
                        <option value="">-- Select Risk Level --</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Very High">Very High</option>
                        <option value="Critical">Critical</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Risk Flag</label>
                    <input type="text" name="risk_flag" class="w-full border rounded px-2 py-1 text-sm" placeholder="e.g. Seized, Dangerous, Suspect">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Save</button>
                    <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-gray-300 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

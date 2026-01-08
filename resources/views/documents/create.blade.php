<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-4">Submit Document</h1>

            <form action="{{ route('documents.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Case ID *</label>
                    <input type="text" name="case_id" class="w-full border rounded px-2 py-1 text-sm" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Type *</label>
                    <select name="category" class="w-full border rounded px-2 py-1 text-sm" required>
                        <option>Declaration</option>
                        <option>Invoice</option>
                        <option>Shipping</option>
                        <option>Certificate</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">File Name *</label>
                    <input type="text" name="filename" class="w-full border rounded px-2 py-1 text-sm" required>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">MIME Type</label>
                    <input type="text" name="mime_type" class="w-full border rounded px-2 py-1 text-sm">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Pages</label>
                    <input type="number" name="pages" class="w-full border rounded px-2 py-1 text-sm" min="1">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-3 py-1 bg-purple-500 text-white rounded">Save</button>
                    <a href="{{ route('dashboard') }}" class="px-3 py-1 bg-gray-300 rounded">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

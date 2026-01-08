<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Document</h1>

            <form action="{{ route('documents.update', $document->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Case ID</label>
                    <input type="text" value="{{ $document->case_id }}" class="w-full border border-gray-300 rounded px-3 py-2 text-sm bg-gray-100" disabled>
                    <p class="text-xs text-gray-500 mt-1">Case ID cannot be changed</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Type *</label>
                    <select name="category" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('category') border-red-500 @enderror" required>
                        <option value="declaration" {{ $document->category === 'declaration' ? 'selected' : '' }}>Declaration (Customs Form)</option>
                        <option value="invoice" {{ $document->category === 'invoice' ? 'selected' : '' }}>Invoice</option>
                        <option value="shipping" {{ $document->category === 'shipping' ? 'selected' : '' }}>Shipping Document</option>
                        <option value="certificate" {{ $document->category === 'certificate' ? 'selected' : '' }}>Certificate of Origin</option>
                        <option value="packing_list" {{ $document->category === 'packing_list' ? 'selected' : '' }}>Packing List</option>
                        <option value="other" {{ $document->category === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Name *</label>
                    <input type="text" name="filename" class="w-full border border-gray-300 rounded px-3 py-2 text-sm @error('filename') border-red-500 @enderror" value="{{ old('filename', $document->filename) }}" required>
                    @error('filename')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">MIME Type</label>
                    <input type="text" name="mime_type" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" value="{{ old('mime_type', $document->mime_type) }}">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Pages</label>
                    <input type="number" name="pages" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" value="{{ old('pages', $document->pages) }}" min="1">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600">
                        Update Document
                    </button>
                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this document?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete Document
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

<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded shadow p-6">
                <h1 class="text-2xl font-bold mb-6">Create New User</h1>

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-800 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror">
                        @error('username')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror">
                        @error('full_name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role" name="role" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror">
                            <option value="">Select a role</option>
                            <option value="inspector" @selected(old('role') === 'inspector')>Inspector</option>
                            <option value="analyst" @selected(old('role') === 'analyst')>Analyst</option>
                            <option value="broker" @selected(old('role') === 'broker')>Broker</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-3 bg-blue-50 border border-blue-200 rounded">
                        <p class="text-sm text-blue-800"><strong>Note:</strong> The password will be set to the username. User can change it later.</p>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create User</button>
                        <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

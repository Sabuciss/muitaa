<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">

        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-bold mb-4">Create New User</h2>
                <form action="{{ route('admin.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Username</label>
                        <input type="text" name="username" required class="w-full border px-3 py-2 rounded @error('username') border-red-500 @enderror" value="{{ old('username') }}">
                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text" name="full_name" required class="w-full border px-3 py-2 rounded @error('full_name') border-red-500 @enderror" value="{{ old('full_name') }}">
                        @error('full_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Role</label>
                        <select name="role" required class="w-full border px-3 py-2 rounded">
                            <option value="">Select role</option>
                            <option value="inspector">Inspector</option>
                            <option value="analyst">Analyst</option>
                            <option value="broker">Broker</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-3 flex items-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create User</button>
                        <span class="text-xs text-gray-500">(Password auto-generated as username)</span>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded shadow p-4">
                <h2 class="text-lg font-bold mb-4">User List</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 p-3 rounded">
                        <div class="text-xs text-gray-600">Inspectors</div>
                        <div class="text-2xl font-bold text-blue-600">{{ $roleStats['inspector'] }}</div>
                    </div>
                    <div class="bg-green-50 p-3 rounded">
                        <div class="text-xs text-gray-600">Analysts</div>
                        <div class="text-2xl font-bold text-green-600">{{ $roleStats['analyst'] }}</div>
                    </div>
                    <div class="bg-purple-50 p-3 rounded">
                        <div class="text-xs text-gray-600">Brokers</div>
                        <div class="text-2xl font-bold text-purple-600">{{ $roleStats['broker'] }}</div>
                    </div>
                    <div class="bg-red-50 p-3 rounded">
                        <div class="text-xs text-gray-600">Admins</div>
                        <div class="text-2xl font-bold text-red-600">{{ $roleStats['admin'] }}</div>
                    </div>
                </div>

                @if ($message = session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-800 rounded">
                        {{ $message }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="text-left px-3 py-2">Username</th>
                                <th class="text-left px-3 py-2">Full Name</th>
                                <th class="text-left px-3 py-2">Role</th>
                                <th class="text-left px-3 py-2">Status</th>
                                <th class="text-left px-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-2 font-mono text-xs">{{ $user->username }}</td>
                                    <td class="px-3 py-2">{{ $user->full_name }}</td>
                                    <td class="px-3 py-2 min-w-[30px]">
                                        <form action="{{ route('admin.update', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="role" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded border w-full">
                                                <option value="inspector" @selected($user->role === 'inspector')>Inspector</option>
                                                <option value="analyst" @selected($user->role === 'analyst')>Analyst</option>
                                                <option value="broker" @selected($user->role === 'broker')>Broker</option>
                                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-3 py-2">
                                        @if ($user->active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Active</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 space-x-2">
                                        <a href="{{ route('admin.edit', $user->id) }}" class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded hover:bg-blue-200">Edit</a>
                                        <form action="{{ route('admin.update', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="toggle_active" value="1">
                                            <button type="submit" class="px-2 py-1 text-xs rounded {{ $user->active ? 'bg-red-100 text-red-800 hover:bg-red-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                {{ $user->active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded hover:bg-gray-200">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>

    </div>
</x-app-layout>

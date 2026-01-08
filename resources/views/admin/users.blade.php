<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6">

        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white rounded shadow p-4">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">User Management</h1>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create User</a>
                </div>

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
                                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
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
                                        <a href="{{ route('admin.users.edit', $user) }}" class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded hover:bg-blue-200">Edit</a>
                                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2 py-1 text-xs rounded {{ $user->active ? 'bg-red-100 text-red-800 hover:bg-red-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
                                                {{ $user->active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        @if (auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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

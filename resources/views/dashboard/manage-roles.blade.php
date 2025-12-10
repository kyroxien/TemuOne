<x-layouts.app title="Manage User Roles">
    <div class="p-6">

        <h1 class="text-2xl font-bold mb-4">Manage User Roles</h1>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if($users->isEmpty())
            <p class="text-gray-500">Tidak ada user tersedia.</p>
        @else
            <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Role Saat Ini</th>
                        <th class="p-3 text-left">Ubah Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">
                                {{ implode(', ', $user->getRoleNames()->toArray()) }}
                            </td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('superadmin.update-role', ['user' => $user->id]) }}">
                                    @csrf
                                    <select name="role" class="rounded border px-2 py-1">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button 
                                        type="submit" 
                                        class="ml-2 rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
                                    >
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-layouts.app>
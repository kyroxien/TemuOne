<x-layouts.app title="Blocked Users">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Blocked Users</h1>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if($blockedUsers->isEmpty())
            <p class="text-gray-500">Tidak ada user yang diblokir saat ini.</p>
        @else
            <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Role</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blockedUsers as $user)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('superadmin.unblock-user', $user) }}">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="rounded bg-green-500 px-4 py-2 text-white hover:bg-green-600"
                                    >
                                        Unblock
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

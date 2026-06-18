<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-xl font-bold">
                        Daftar User
                    </h1>

                    <a href="{{ route('users.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded">
                        + Tambah User
                    </a>
                </div>

                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Role</th>
                            <th class="border p-2">Outlet</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="border p-2 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border p-2">
                                    {{ $user->name }}
                                </td>

                                <td class="border p-2">
                                    {{ $user->email }}
                                </td>

                                <td class="border p-2">
                                    {{ $user->getRoleNames()->first() }}
                                </td>

                                <td class="border p-2">
                                    {{ $user->outlet->name ?? '-' }}
                                </td>

                                <td class="border p-2 text-center">
                                    Edit | Hapus
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-4">
                                    Belum ada user
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-app-layout>
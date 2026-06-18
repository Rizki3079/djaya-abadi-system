<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Outlet Management
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400
                                text-green-700 px-4 py-3 rounded mb-4">

                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-xl font-bold">
                        Daftar Outlet
                    </h1>

                    <a href="{{ route('outlets.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded">
                        + Tambah Outlet
                    </a>
                </div>

                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Nama Outlet</th>
                            <th class="border p-2">Kode</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                            @forelse ($outlets as $outlet)
                                <tr>
                                    <td class="border p-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border p-2">
                                        {{ $outlet->name }}
                                    </td>

                                    <td class="border p-2">
                                        {{ $outlet->code }}
                                    </td>

                                    <td class="border p-2">
                                        {{ ucfirst($outlet->status) }}
                                    </td>

                                    <td class="border p-2 text-center">
                                        <a href="{{ route('outlets.edit', $outlet->id) }}"
                                        class="text-blue-500">

                                            Edit
                                        </a>| Hapus
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4">
                                        Belum ada data outlet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>
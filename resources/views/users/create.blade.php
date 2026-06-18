<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah User
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 rounded border border-red-400 bg-red-100 p-4 text-red-700">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full rounded border-gray-300"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded border-gray-300"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full rounded border-gray-300"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-medium">
                            Role
                        </label>

                        <select
                            name="role"
                            class="w-full rounded border-gray-300"
                            required
                        >
                            <option value="">
                                -- Pilih Role --
                            </option>

                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->name }}"
                                    {{ old('role') == $role->name ? 'selected' : '' }}
                                >
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-medium">
                            Outlet
                        </label>

                        <select
                            name="outlet_id"
                            class="w-full rounded border-gray-300"
                        >
                            <option value="">
                                -- Pilih Outlet --
                            </option>

                            @foreach ($outlets as $outlet)
                                <option
                                    value="{{ $outlet->id }}"
                                    {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}
                                >
                                    {{ $outlet->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button
                            type="submit"
                            style="background:#2563eb;color:white;padding:10px 20px;border-radius:6px;"
                        >
                            Simpan
                        </button>

                        <a
                            href="{{ route('users.index') }}"
                            style="background:#6b7280;color:white;padding:10px 20px;border-radius:6px;text-decoration:none;"
                        >
                            Kembali
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
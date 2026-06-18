<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Outlet
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400
                                text-red-700 px-4 py-3 rounded mb-4">

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('outlets.store') }}"
                      method="POST">

                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2">
                            Nama Outlet
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">
                            Kode Outlet
                        </label>

                        <input type="text"
                               name="code"
                               value="{{ old('code') }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">
                            Status
                        </label>

                        <select name="status"
                                class="w-full border rounded p-2">

                            <option value="active"
                                {{ old('status') == 'active' ? 'selected' : '' }}>>
                                Active
                            </option>

                            <option value="inactive"
                                <option value="inactive"
                                {{ old('status') == 'inactive' ? 'selected' : '' }}>>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">

                            Simpan
                        </button>

                        <a href="{{ route('outlets.index') }}"
                           class="bg-gray-500 text-white px-4 py-2 rounded">

                            Kembali
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
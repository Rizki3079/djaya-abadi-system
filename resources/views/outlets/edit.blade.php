<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Outlet
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('outlets.update', $outlet->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-2">
                            Nama Outlet
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ $outlet->name }}"
                               class="w-full border rounded p-2"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">
                            Kode Outlet
                        </label>

                        <input type="text"
                               name="code"
                               value="{{ $outlet->code }}"
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
                                {{ $outlet->status == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ $outlet->status == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Kategori Pendapatan
                        </label>

                        @foreach($incomeCategories as $category)
                            <div>
                                <input
                                    type="checkbox"
                                    name="income_categories[]"
                                    value="{{ $category->id }}"
                                >

                                {{ $category->name }}
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">
                            Metode Pembayaran
                        </label>

                        @foreach($paymentMethods as $method)
                            <div>
                                <input
                                    type="checkbox"
                                    name="payment_methods[]"
                                    value="{{ $method->id }}"
                                >

                                {{ $method->name }}
                            </div>
                        @endforeach
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded">

                            Update
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
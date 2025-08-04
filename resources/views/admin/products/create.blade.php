<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kendaraan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data"
                        id="product-form">
                        @csrf

                        <!-- Nama Kendaraan -->
                        <div>
                            <x-input-label for="name" :value="__('Nama Kendaraan')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                        </div>

                        <!-- Kategori -->
                        <div class="mt-4">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select name="category_id" id="category_id"
                                class="block mt-1 w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga -->
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Harga')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                                :value="old('price')" required />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea name="description" id="description" rows="5"
                                class="block mt-1 w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>

                        <!-- Gambar -->
                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Gambar Kendaraan')" />
                            <input id="image" name="image" type="file"
                                class="mt-1 block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-md shadow-sm p-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('product-form');
                const priceInput = document.getElementById('price');

                if (form && priceInput) {
                    // Fungsi untuk memformat angka dengan titik
                    const formatNumber = (value) => {
                        if (!value) return '';
                        let number = value.toString().replace(/[^0-9]/g, '');
                        return new Intl.NumberFormat('id-ID').format(number);
                    };

                    // Fungsi untuk menghapus format sebelum submit
                    const unformatNumber = (value) => {
                        if (!value) return '';
                        return value.toString().replace(/[^0-9]/g, '');
                    };

                    // Format saat pengguna mengetik
                    priceInput.addEventListener('input', (e) => {
                        e.target.value = formatNumber(e.target.value);
                    });

                    // Hapus format sebelum form disubmit
                    form.addEventListener('submit', (e) => {
                        priceInput.value = unformatNumber(priceInput.value);
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>

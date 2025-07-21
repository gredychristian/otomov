<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otomov Marketplace</title>
    <link rel="icon" href="{{ asset('images/otomov.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-slate-50">
    <div class="relative min-h-screen">
        @include('layouts.navigation')

        <main class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">Keranjang Belanja Anda</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    @if(Cart::count() == 0)
                        <p class="text-center text-gray-500 py-10">Keranjang Anda masih kosong.</p>
                    @else
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <li class="flex py-6">
                                    <div class="h-24 w-32 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        @if($item->options->image)
                                            <img src="{{ asset('storage/' . $item->options->image) }}" alt="{{ $item->name }}" class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gray-100">
                                                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>{{ $item->name }}</h3>
                                                <p class="ml-4">Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Jumlah: {{ $item->qty }}</p>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm">
                                            <p class="text-gray-500">@ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                            <div class="flex">
                                                <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-sky-600 hover:text-sky-500">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Total</p>
                                <p>Rp {{ Cart::total(0, ',', '.') }}</p>
                            </div>
                            <p class="mt-0.5 text-sm text-gray-500">Biaya pengiriman akan dihitung saat checkout.</p>
                            <div class="mt-6">
                                <form action="{{ route('checkout.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-sky-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-sky-700">
                                        Konfirmasi & Proses Pesanan
                                    </button>
                                </form>
                            </div>
                            <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                <p>
                                    atau
                                    <a href="{{ route('home') }}" class="font-medium text-sky-600 hover:text-sky-500">
                                        Lanjut Belanja<span aria-hidden="true"> &rarr;</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>

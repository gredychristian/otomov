<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan #' . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 border-b border-gray-200">
                    {{-- Informasi Pesanan --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <div class="text-sm text-gray-500">Nomor Pesanan</div>
                            <div class="font-bold text-gray-800">#{{ $order->id }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Tanggal</div>
                            <div class="font-bold text-gray-800">{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Status</div>
                            <div class="font-bold text-gray-800">
                                <span
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Total</div>
                            <div class="font-bold text-gray-800">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Item</h3>
                    {{-- Daftar Item --}}
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-start justify-between">
                                <div class="flex">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-16 w-24 object-cover rounded mr-4">
                                    @else
                                        <div
                                            class="h-16 w-24 flex items-center justify-center bg-gray-100 rounded mr-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            {{ $item->product->name ?? 'Produk Dihapus' }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->quantity }} pcs x Rp
                                            {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">Rp
                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Rincian Harga --}}
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        @php
                            $subtotal = 0;
                            foreach ($order->items as $item) {
                                $subtotal += $item->price * $item->quantity;
                            }
                            $taxAmount = $order->total_price - $subtotal;
                        @endphp
                        <dl class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </dd>
                            </div>
                            @if ($taxAmount > 0)
                                <div class="flex justify-between">
                                    <dt>PPN</dt>
                                    <dd class="font-medium text-gray-900">Rp
                                        {{ number_format($taxAmount, 0, ',', '.') }}</dd>
                                </div>
                            @endif
                            <div
                                class="flex justify-between text-base font-medium text-gray-900 border-t border-gray-200 pt-2 mt-2">
                                <dt>Total</dt>
                                <dd>Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Tombol Unduh Invoice --}}
                    <div class="mt-8 text-center">
                        @if (Auth::user()->is_admin)
                            {{-- Jika yang login adalah admin, arahkan ke rute admin --}}
                            <a href="{{ route('admin.orders.invoice', $order->id) }}"
                                class="inline-block bg-sky-600 border border-transparent rounded-md py-2 px-6 text-base font-medium text-white hover:bg-sky-700">
                                Unduh Invoice
                            </a>
                        @else
                            {{-- Jika pengguna biasa, arahkan ke rute biasa --}}
                            <a href="{{ route('orders.invoice', $order->id) }}"
                                class="inline-block bg-sky-600 border border-transparent rounded-md py-2 px-6 text-base font-medium text-white hover:bg-sky-700">
                                Unduh Invoice
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

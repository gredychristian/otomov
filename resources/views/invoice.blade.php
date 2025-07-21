<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <h2>Otomov Karoseri</h2>
                                Invoice #: {{ $order->id }}<br>
                                Dibuat: {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="text-right">
                                <strong>Ditujukan Kepada:</strong><br>
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td class="text-right">Harga</td>
            </tr>
            @foreach ($order->items as $item)
                <tr class="item">
                    <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                    <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            @php
                // Menghitung subtotal dan pajak dari total akhir
                $taxRate = config('cart.tax') / 100; // mengambil dari config (0.11)
                $subtotal = $order->total_price / (1 + $taxRate);
                $taxAmount = $order->total_price - $subtotal;
            @endphp

            <tr class="item">
                <td></td>
                <td class="text-right">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr class="item">
                <td></td>
                <td class="text-right">PPN ({{ config('cart.tax') }}%): Rp {{ number_format($taxAmount, 0, ',', '.') }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td class="text-right">
                    <strong>Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h3>Detail Pesanan Client: {{ $client->full_name }}</h3>
<ul>
    @foreach ($orderData['order']->items as $item)
        <li>
            {{ $item->product->name }} - Jumlah: {{ $item->quantity }} - 
            Keuntungan: Rp{{ number_format($item->product->profit->amount * $item->quantity, 0, ',', '.') }}
        </li>
    @endforeach
</ul>
<p>Total Keuntungan: Rp{{ number_format($orderData['profit'], 0, ',', '.') }}</p>
</body>
</html> --}}
@include('admin.layouts.top')  
@section('title', $title)  
@include('admin.layouts.navbar') 
<div class="container mt-4">  
    <h2 style="font-weight: 900;">Detail Keranjang: {{ $client->username }}</h2>  
    <div  style="text-align: right">  
        @php  
            $grandTotal = 0;  
            foreach ($client->carts as $cart) {  
                $grandTotal += $cart->quantity * $cart->product->selling_price;  
            }  
        @endphp  
        <h4>Harga Total Rp {{ number_format($grandTotal, 2) }}</h4>  
    </div>  
    <div class="table-responsive">  
       <table class="table">  
            <thead class="sticky-top table-bordered" style="background-color: #4e4feb; color: #fff; z-index: 4">  
             <tr>  
                <th>No</th>  
                <th>Gambar</th>  
                <th >Nama Produk</th>  
                <th >Harga</th>  
                <th style="text-align: center">Jumlah</th>  
                <th >Subtotal</th>  
            </tr>  
        </thead>  
        <tbody>  
            @php $total = 0; @endphp  
            @foreach ($client->carts as $cart)  
            <tr>  
                <td style="vertical-align: middle">{{ $loop->iteration }}</td>   
                <td style="vertical-align: middle"><img src="{{ asset('storage/' . $cart->product->image) }}" style="max-width: 100px; max-height: 100px"></td>   
                <td style="vertical-align: middle">{{ $cart->product->name }}</td>  
                <td style="vertical-align: middle">Rp{{ number_format($cart->product->selling_price, 2) }}</td>  
                <td style="vertical-align: middle; text-align: center">{{ $cart->quantity }}</td>  
                <td style="vertical-align: middle">Rp{{ number_format($cart->quantity * $cart->product->selling_price, 2) }}</td>  
            </tr>  
            @php $total += $cart->quantity * $cart->product->selling_price; @endphp  
            @endforeach  
        </tbody>  
        {{-- <tfoot>  
            <tr>  
                <th colspan="4" class="text-right">Total</th>  
                <th>Rp{{ number_format($grandTotal, 2) }}</th>   
            </tr>  
        </tfoot>   --}}
    </table>  
    </div>  
</div>  
@include('admin.layouts.bot')
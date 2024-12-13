<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="{{ asset('css/navbar/style.css') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
</head>
<body>

<div class="container">  
    <h1>Daftar Paket Produk</h1>  
    <div class="row">  
        @foreach($packages as $package)  
            <div class="col-md-4">  
                <div class="card">  
                    <div class="card-body">  
                        <h5 class="card-title">{{ $package->name }}</h5>  
                        <p class="card-text">{{ $package->description }}</p>  
                        <ul>  
                            @foreach($package->products as $product)  
                                <li>{{ $product->name }} ({{ $product->pivot->quantity }})</li>  
                            @endforeach  
                        </ul>  
                        <p>Harga Paket: Rp {{ number_format($package->total_price, 2) }}</p>  
                        <form method="POST" action="{{ route('client.packages.addToCart', $package) }}">  
                            @csrf  
                            <button class="btn btn-primary">Tambah ke Keranjang</button>  
                        </form>  
                    </div>  
                </div>  
            </div>  
        @endforeach  
    </div>  
</div>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous">
</script>
<script src="{{ asset('java/script.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>  
@stack('scripts')  
</body>  
</html>
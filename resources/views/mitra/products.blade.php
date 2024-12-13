@include('mitra.layouts.top')  
@include('mitra.layouts.nav')  

<div class="container">  
    <h2 class="fw-bold" style="{{ $isMobile ? 'font-size: 4rem;' : '' }}">Daftar Paket Produk</h2>  
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

<div class="container mt-5" style="{{ $isMobile ? ' margin: 5%; width: 160%;' : '' }}">  
    <h2 class="fw-bold" style="{{ $isMobile ? 'font-size: 4rem;' : '' }}">Daftar Produk</h2>  

    @if ($isMobile)
        <form class="row g-8 align-items-center" style="width: 125%; overflow: hidden" role="search" method="GET" action="{{ route('mitra.products') }}">
            <!-- Input pencarian -->
            <div class="col-8" >
                <input 
                    id="searchInput2" 
                    class="form-control" 
                    name="search" 
                    type="text" 
                    placeholder="Cari Produk..." 
                    aria-label="Search"
                    style="font-size: 2rem;" >
            </div>
            <!-- Tombol cari -->
            <div class="col-2">
                <button class="btn btn-outline-primary w-100" type="submit" style="font-size: 2rem;" >
                    Cari
                </button>
            </div>
        </form>
    @endif
    
    

    <br>
    <div class="row" style=" {{ $isMobile ? 'width: 125%;' : '' }}">  
        @forelse($products as $product)  
        <div class="{{ $isMobile ? 'col-6 mb-4' : 'col-6 col-md-4 col-lg-3 col-xl-2 mb-4' }}" >
            <a href="{{ route('mitra.product.detail', $product->id) }}" style="text-decoration: none; color: inherit;">
            <div class="card h-100" style="{{ $isMobile ? 'width: 100%;' : '' }}">  
                @if($product->image)   
                <img src="{{ asset('storage/' . $product->image) }}"   
                     class="card-img-top"   
                     alt="{{ $product->name }}"  
                     style="height: 180px; object-fit: cover;">  
                @endif  
                <div class="card-body">    
                    <h5 class="card-title" style=" {{ $isMobile ? 'font-size: 2rem;' : 'font-size: 1rem;' }} font-weight: 700;">{{ $product->name }}</h5>  
                    <p class="card-text" style="{{ $isMobile ? 'font-size: 1.7rem;' : 'font-size: 0.85rem;' }}">  
                        <strong>Harga:</strong> Rp{{ number_format($product->selling_price, 2) }}<br>  
                        <strong>Stok:</strong> {{ $product->stock->quantity ?? 0 }}   
                    </p>  
            
                    {{-- <a href="{{ route('mitra.product.detail', $product->id) }}"   
                       class="btn btn-primary btn-sm"  
                       style="{{ $isMobile ? 'font-size: 1.7rem;' : '' }}">  
                        Lihat Detail  
                    </a>   --}}
            
                    @if(($product->stock->quantity ?? 0) > 0)
                    @guest('client') 
                    <form action="{{ route('client.login') }}" style="display: inline-block;">  
                        @csrf  
                        <button type="submit"  
                                class="btn btn-success btn-sm"  
                                style="{{ $isMobile ? 'font-size: 1.7rem;' : '' }}">  
                                <i class="bi bi-cart3"></i>
                        </button>  
                    </form> 
                    @else
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline-block;">  
                        @csrf  
                        <button type="submit"  
                                class="btn btn-success btn-sm"  
                                style="{{ $isMobile ? 'font-size: 1.7rem;' : '' }}">  
                                <i class="bi bi-cart3"></i>
                        </button>  
                    </form> 
                    @endguest  
                    @else  
                    {{-- Jika stok kosong --}}  
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="popover" data-bs-title="Stok Habis" data-bs-content="Stok produk ini telah habis. Silakan pilih produk lain."
                            style="{{ $isMobile ? 'font-size: 1.7rem;' : '' }}">  
                            <i class="bi bi-cart-x"></i> 
                    </button>  
                    @endif  
                </div>  
            </div>
            </a>
        </div>
              
        @empty  
            <div class="col-12">  
                <div class="alert alert-info text-center">  
                    Tidak ada produk yang tersedia.  
                </div>  
            </div>  
        @endforelse 
         
    </div>  



    
</div>  
@extends('mitra.layouts.footer')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi semua elemen dengan popover
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>
<script>  
    document.addEventListener('DOMContentLoaded', function() {  
    // Fitur Pencarian Kedua  
    const searchInput2 = document.getElementById('searchInput2');  
    const searchHistory2 = JSON.parse(localStorage.getItem('searchHistory2')) || [];  
    
    if (searchHistory2.length > 0) {  
        searchInput2.value = searchHistory2[searchHistory2.length - 1];  
    }  

    searchInput2.addEventListener('change', function() {  
        const searchTerm = this.value.trim();  
        if (searchTerm && !searchHistory2.includes(searchTerm)) {  
            searchHistory2.push(searchTerm);  
            localStorage.setItem('searchHistory2', JSON.stringify(searchHistory2));  
        }  
    }); 
    });  
</script>
</body>  
</html>
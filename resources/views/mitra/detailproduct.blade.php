<!DOCTYPE html>  
<html lang="id">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detail Produk</title>  
    <link rel="icon" href="{{ asset('IMG/Logo KM.png') }}" type="image/png" />  
</head>  
<body>  
    <div class="container mt-5">  
        <div class="row">  
            <div class="col-md-6">  
                @if($product->image)   
                <img src="{{ asset('storage/' . $product->image) }}"   
                     class="img-fluid rounded"   
                     alt="{{ $product->name }}">  
                @endif  
            </div>  
            <div class="col-md-6">  
                <h1>{{ $product->name }}</h1>  
                
                <div class="card">  
                    <div class="card-body">  
                        <h5 class="card-title">Informasi Produk</h5>  
                        <table class="table">  
                            <tr>  
                                <th>Harga</th>  
                                <td>Rp{{ number_format($product->selling_price, 2) }}</td>  
                            </tr>  
                            <tr>  
                                <th>Stok</th>  
                                <td>{{ $product->stock->quantity ?? 0 }}</td>  
                            </tr>  
                            <tr>  
                                <th>Deskripsi</th>  
                                <td>{{ $product->description ?? 'Tidak ada deskripsi' }}</td>  
                            </tr>  
                            <tr>  
                                <th>Terakhir Diperbarui</th>  
                                <td>{{ $product->updated_at->format('d M Y H:i') }}</td>  
                            </tr>  
                            <tr>  
                                <th>Kategori</th>  
                                <td>{{ $product->category_product }}</td>  
                            </tr>  
                            <tr>
                                <th></th>
                                <td>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                                        Produk Serupa
                                    </button>
                                    @if(($product->stock->quantity ?? 0) > 0) {{-- Jika stok lebih dari 0 --}}  
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
                                    <button class="btn btn-secondary btn-sm" disabled  
                                            style="{{ $isMobile ? 'font-size: 1.7rem;' : '' }}">  
                                        Stok Habis  
                                    </button>  
                                    @endif  
                                </td>
                            </tr>
                        </table>  
                    </div>  
                </div>  

                <div class="mt-3">  
                    <a href="{{ route('mitra.products') }}" class="btn btn-secondary">  
                        Kembali ke Daftar Produk  
                    </a>  
                </div>  
                <div class="mt-3">  
                    @php  
                        $productName = urlencode($product->name);  
                        $productPrice = number_format($product->selling_price, 0, ',', '.');  
                        $productStock = $product->stock->quantity ?? 0;  
                        $message = "Hallo %0ASaya tertarik dengan produk *$productName* dengan Harga: Rp$productPrice dan dengan Stok: $productStock %0ASaya ingin membeli nya";                         
                        $whatsappLink = "https://wa.me/6289663983455?text=" . $message;  
                    @endphp  
                    <a href="{{ $whatsappLink }}" class="btn btn-success" target="_blank">  
                        <i class="bi bi-whatsapp"></i> Hubungi via WhatsApp  
                    </a>  
                </div>  

            </div>  
        </div>  

        <div class="container mt-5">  
            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">  
                <div class="offcanvas-header">  
                    <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Produk Yang Serupa</h5>  
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>  
                </div>  
                <div class="offcanvas-body">  
                    <div class="row" style="{{ $isMobile ? 'width: 100%;' : '' }}">  
                        @forelse($products as $relatedProduct)  
                            <div class="{{ $isMobile ? 'col-6 mb-4' : 'col-md-6 mb-4' }}">  <!-- Changed here to 'col-6' for mobile -->  
                                <div class="card" style="{{ $isMobile ? 'width: 100%;' : '' }}">  <!-- Adjusted width -->  
                                    @if($relatedProduct->image)  
                                        <img src="{{ asset('storage/' . $relatedProduct->image) }}"  
                                             class="card-img-top"  
                                             alt="{{ $relatedProduct->name }}"  
                                             style="height: 180px; object-fit: cover;">  
                                    @endif  
                                    <div class="card-body">  
                                        <h5 class="card-title" style="{{ $isMobile ? 'font-size: 1rem;' : 'font-size: 1rem;' }} font-weight: 700;">{{ $relatedProduct->name }}</h5>  
                                        <p class="card-text" style="{{ $isMobile ? 'font-size: 0.7rem;' : 'font-size: 0.85rem;' }}">  
                                            <strong>Harga:</strong> Rp{{ number_format($relatedProduct->selling_price, 2) }}<br>  
                                            <strong>Stok:</strong> {{ $relatedProduct->stock->quantity ?? 0 }}  
                                        </p>  
                                        <a href="{{ route('mitra.product.detail', $relatedProduct->id) }}"  
                                           class="btn btn-primary btn-sm"  
                                           style="{{ $isMobile ? 'font-size: 0.7rem;' : '' }}">  
                                            Lihat Detail  
                                        </a>  
                                    </div>  
                                </div>  
                            </div>  
                        @empty  
                            <div class="col-12">  
                                <div class="alert alert-info text-center">  
                                    Tidak ada produk yang serupa.  
                                </div>  
                            </div>  
                        @endforelse   
                    </div>  
                </div>  
            </div>  
        </div>
        
    </div>  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>  
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const offcanvasElementList = document.querySelectorAll('.offcanvas');
        const offcanvasList = [...offcanvasElementList].map(offcanvasEl => new bootstrap.Offcanvas(offcanvasEl));
        });

    </script> 
</body>  
</html>
@include('admin.layouts.top')  
@section('title', $title)  
@include('admin.layouts.navbar')  

<div class="container mt-5">  
    <div class="row align-items-center mb-4">  
        <div class="col">  
            <h2 class="fw-bold text-primary">Daftar Produk</h2>  
        </div>  
        <div class="col-auto">  
            <div class="alert alert-info mb-0 py-2 px-3 shadow-sm">  
                <strong>Total Keuntungan:</strong> Rp {{ number_format($totalProfit, 2) }}  
            </div>  
        </div>  
    </div>  

    @if(session('success'))  
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050; {{ $isMobile ? 'width: 80%;' : '' }}">  
            <div class="toast bg-success text-white" role="alert">  
                <div class="toast-header bg-success text-white">  
                    <strong class="me-auto">Perubahan Produk</strong>  
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>  
                </div>  
                <div class="toast-body">  
                    {{ session('success') }}  
                </div>  
            </div>  
        </div>  
    @endif  

    <div class="card shadow-sm mb-4">  
        <div class="card-body">  
            <form method="GET" action="{{ route('admin.products.read') }}" class="row g-2">  
                <div class="col-md-8">  
                    <div class="input-group position-relative">  
                        <input   
                            id="searchInput"   
                            type="text"   
                            name="search"   
                            class="form-control"   
                            placeholder="Cari produk..."   
                            autocomplete="off"  
                        >  
                        <button class="btn btn-primary" type="submit">  
                            <i class="bi bi-search me-2"></i>Cari  
                        </button>  
                        
                        <!-- Dropdown hasil pencarian -->  
                        <div id="searchResultsDropdown" class="card search-results-dropdown shadow-lg">  
                            <div class="card-body p-0">  
                                <ul id="searchResultsList" class="list-group list-group-flush">  
                                    <!-- Hasil pencarian akan dimuat di sini -->  
                                </ul>  
                            </div>  
                        </div>  
                    </div>  
                </div>  
                <div class="col-md-4 text-end">  
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">  
                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk  
                    </a>  
                </div>  
            </form>  
        </div>  
    </div>  

    <div class="card shadow-sm">  
        <div class="table-responsive">  
            <table class="table table-hover mb-0">  
                <thead class="table-light">  
                    <tr>  
                        <th>ID</th>  
                        <th>Nama Produk</th>  
                        <th>Harga Beli</th>  
                        <th>Harga Jual</th>  
                        <th>Stok</th>  
                        <th>Keuntungan</th>  
                        <th>Kategori</th>  
                        <th class="text-center">Aksi</th>  
                    </tr>  
                </thead>  
                <tbody>  
                    @foreach($products as $product)  
                        <tr>  
                            <td>{{ $product->product_id }}</td>  
                            <td>  
                                <div class="d-flex align-items-center">  
                                    @if($product->image)  
                                        <img src="{{ asset('storage/' . $product->image) }}" class="rounded me-3" alt="Produk" style="width: 50px; height: 50px; object-fit: cover;">  
                                    @endif  
                                    <div>  
                                        <strong>{{ $product->name }}</strong>  
                                        <small class="d-block text-muted">  
                                            {{ strlen($product->description) > 30 ? substr($product->description, 0, 30) . '...' : $product->description }}  
                                        </small>  
                                    </div>  
                                </div>  
                            </td>  
                            <td>Rp {{ number_format($product->purchase_price, 2) }}</td>  
                            <td>Rp {{ number_format($product->selling_price, 2) }}</td>  
                            <td>  
                                <span class="badge {{ $product->stock->quantity < 10 ? 'bg-danger' : 'bg-success' }}">  
                                    {{ $product->stock->quantity ?? 0 }}  
                                </span>  
                            </td>  
                            <td>Rp {{ number_format($product->profit ?? 0, 2) }}</td>  
                            <td>  
                                <span class="badge bg-secondary">  
                                    {{ $product->category_product }}  
                                </span>  
                            </td>  
                            <td>  
                                <div class="d-flex justify-content-center">  
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="tooltip" title="Edit">  
                                        <i class="bi bi-pencil"></i>  
                                    </a>  
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}" data-bs-tooltip="Hapus">  
                                        <i class="bi bi-trash"></i>  
                                    </button>  
                                
                                    <!-- Modal Hapus -->  
                                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1">  
                                      <div class="modal-dialog modal-dialog-centered">  
                                        <div class="modal-content">  
                                          <div class="modal-header border-0">  
                                            <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>  
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>  
                                          </div>  
                                          <div class="modal-body text-center">  
                                            Yakin hapus produk <strong class="text-primary">{{ $product->name }}</strong>?  
                                          </div>  
                                          <div class="modal-footer border-0">  
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>  
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">  
                                              @csrf  
                                              @method('DELETE')  
                                              <button type="submit" class="btn btn-danger">Hapus</button>  
                                            </form>  
                                          </div>  
                                        </div>  
                                      </div>  
                                    </div>  
                                </div>  
                            </td>  
                        </tr>  
                    @endforeach  
                </tbody>  
            </table>  
        </div>  
        
        <div class="card-footer">  
            <div class="d-flex justify-content-between align-items-center">  
                <div class="text-muted small">  
                    Menampilkan   
                    {{ $products->firstItem() }} -   
                    {{ $products->lastItem() }}   
                    dari {{ $products->total() }} produk  
                </div>  
        
                <nav>  
                    <ul class="pagination mb-0">  
                        @if (!$products->onFirstPage())  
                            <li class="page-item">  
                                <a class="page-link" href="{{ $products->previousPageUrl() }}">  
                                    <i class="bi bi-chevron-left"></i>  
                                </a>  
                            </li>  
                        @endif  
                        
                        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)  
                            <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">  
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>  
                            </li>  
                        @endforeach  
                        
                        @if ($products->hasMorePages())  
                            <li class="page-item">  
                                <a class="page-link" href="{{ $products->nextPageUrl() }}">  
                                    <i class="bi bi-chevron-right"></i>  
                                </a>  
                            </li>  
                        @endif  
                    </ul>  
                </nav>  
            </div>  
        </div>  
    </div>  
</div>  

<script>  
    document.addEventListener('DOMContentLoaded', function () {  
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))  
        var toastList = toastElList.map(function (toastEl) {  
            return new bootstrap.Toast(toastEl, { autohide: true, delay: 3000 });  
        });  
        toastList.forEach(toast => toast.show());  

        // Aktifkan tooltip Bootstrap  
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))  
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {  
            return new bootstrap.Tooltip(tooltipTriggerEl)  
        });  
    });  
</script>  
<script>  
    document.addEventListener('DOMContentLoaded', function() {  
        const searchInput = document.getElementById('searchInput');  
        const searchResultsDropdown = document.getElementById('searchResultsDropdown');  
        const searchResultsList = document.getElementById('searchResultsList');  
        
        // Fitur pencarian riwayat  
        const searchHistory = JSON.parse(localStorage.getItem('productSearchHistory')) || [];  
        
        // Fungsi untuk menyimpan riwayat pencarian  
        function saveSearchHistory(term) {  
            if (term && !searchHistory.includes(term)) {  
                if (searchHistory.length >= 10) {  
                    searchHistory.shift(); // Hapus pencarian tertua jika lebih dari 10  
                }  
                searchHistory.push(term);  
                localStorage.setItem('productSearchHistory', JSON.stringify(searchHistory));  
            }  
        }  
    
        // Fungsi untuk menampilkan riwayat pencarian  
        function displaySearchHistory() {  
            searchResultsList.innerHTML = ''; // Bersihkan hasil sebelumnya  
            
            // Tambahkan riwayat pencarian  
            searchHistory.reverse().forEach(term => {  
                const historyItem = document.createElement('li');  
                historyItem.classList.add('list-group-item', 'list-group-item-action', 'search-results-item');  
                historyItem.innerHTML = `  
                    <div class="d-flex justify-content-between align-items-center">  
                        <span>${term}</span>  
                        <small class="text-muted">Riwayat</small>  
                    </div>  
                `;  
                historyItem.addEventListener('click', () => {  
                    searchInput.value = term;  
                    performSearch(term);  
                });  
                searchResultsList.appendChild(historyItem);  
            });  
    
            // Tampilkan dropdown jika ada riwayat  
            if (searchHistory.length > 0) {  
                searchResultsDropdown.classList.add('show');  
            }  
        }  
    
        // Fungsi pencarian real-time  
        function performSearch(query) {  
            if (query.length < 2) {  
                searchResultsDropdown.classList.remove('show');  
                return;  
            }  
    
            fetch(`/admin/products/search?query=${encodeURIComponent(query)}`)  
                .then(response => response.json())  
                .then(products => {  
                    searchResultsList.innerHTML = ''; // Bersihkan hasil sebelumnya  
    
                    if (products.length === 0) {  
                        const noResultItem = document.createElement('li');  
                        noResultItem.classList.add('list-group-item', 'text-center', 'text-muted');  
                        noResultItem.textContent = 'Tidak ada produk ditemukan';  
                        searchResultsList.appendChild(noResultItem);  
                    } else {  
                        products.forEach(product => {  
                            const productItem = document.createElement('li');  
                            productItem.classList.add('list-group-item', 'list-group-item-action', 'search-results-item');  
                            productItem.innerHTML = `  
                                <div class="d-flex align-items-center">  
                                    ${product.image ?   
                                        `<img src="/storage/${product.image}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">`   
                                        :   
                                        ''  
                                    }  
                                    <div>  
                                        <strong>${product.name}</strong>  
                                        <div class="small text-muted">  
                                            Stok: ${product.stock} | Harga: Rp ${product.selling_price.toLocaleString()}  
                                        </div>  
                                    </div>  
                                </div>  
                            `;  
                            productItem.addEventListener('click', () => {  
                                window.location.href = `/admin/products/${product.id}/edit`;  
                            });  
                            searchResultsList.appendChild(productItem);  
                        });  
                    }  
    
                    searchResultsDropdown.classList.add('show');  
                })  
                .catch(error => {  
                    console.error('Error:', error);  
                });  
        }  
    
        // Event listener untuk input pencarian  
        searchInput.addEventListener('input', function() {  
            const query = this.value.trim();  
            performSearch(query);  
        });  
    
        // Tampilkan riwayat pencarian saat input difokuskan  
        searchInput.addEventListener('focus', function() {  
            if (searchHistory.length > 0) {  
                displaySearchHistory();  
            }  
        });  
    
        // Sembunyikan dropdown saat klik di luar  
        document.addEventListener('click', function(event) {  
            if (!searchInput.contains(event.target) && !searchResultsDropdown.contains(event.target)) {  
                searchResultsDropdown.classList.remove('show');  
            }  
        });  
    
        // Simpan riwayat pencarian saat form disubmit  
        document.querySelector('form').addEventListener('submit', function(event) {  
            const query = searchInput.value.trim();  
            saveSearchHistory(query);  
        });  
    });  
    </script>  
    @push('scripts')  
    <script src="{{ asset('js/product-search.js') }}"></script>  
    @endpush

@extends('admin.layouts.bot')
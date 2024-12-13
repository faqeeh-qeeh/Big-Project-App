<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Detail Paket</title>  
    
    <!-- Bootstrap CSS -->  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">  
    
    <!-- Custom Icons -->  
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">  
    
    <!-- Custom Styles -->  
    <style>  
        body {  
            background-color: #f4f6f9;  
        }  
        .card {  
            border-radius: 12px;  
            overflow: hidden;  
        }  
        .card-header {  
            background-color: #4a5568;  
            color: white;  
        }  
        .package-info {  
            background-color: #f9fafb;  
            border-radius: 8px;  
        }  
        .product-list .list-group-item {  
            transition: background-color 0.3s ease;  
        }  
        .product-list .list-group-item:hover {  
            background-color: #f1f3f5;  
        }  
    </style>  
</head>  
<body>  
<div class="container-fluid py-4">  
    <div class="row justify-content-center">  
        <div class="col-lg-10 col-xl-8">  
            <div class="card shadow-lg">  
                <!-- Header -->  
                <div class="card-header d-flex justify-content-between align-items-center">  
                    <h1 class="h4 mb-0">  
                        <i class="fas fa-box-open me-2"></i>Detail Paket: {{ $package->name }}  
                    </h1>  
                </div>  

                <!-- Body -->  
                <div class="card-body">  
                    <div class="row g-4">  
                        <!-- Package Details -->  
                        <div class="col-md-8">  
                            <div class="package-info p-4">  
                                <div class="mb-4">  
                                    <h5 class="text-muted mb-2">Deskripsi Paket</h5>  
                                    <p class="lead text-dark">{{ $package->description }}</p>  
                                </div>  
                                
                                <div>  
                                    <h5 class="text-muted mb-2">Total Harga</h5>  
                                    <h3 class="text-success fw-bold">  
                                        Rp. {{ number_format($package->total_price, 0, ',', '.') }}  
                                    </h3>  
                                </div>  
                            </div>  
                        </div>  

                        <!-- Products in Package -->  
                        <div class="col-md-4">  
                            <div class="card border-0 shadow-sm product-list">  
                                <div class="card-header bg-light">  
                                    <h4 class="h5 mb-0">Produk dalam Paket</h4>  
                                </div>  
                                <div class="list-group list-group-flush">  
                                    @foreach($package->products as $product)  
                                        <div class="list-group-item d-flex justify-content-between align-items-center">  
                                            <span class="text-dark">{{ $product->name }}</span>  
                                            <span class="badge bg-primary rounded-pill">  
                                                {{ $product->pivot->quantity }}  
                                            </span>  
                                        </div>  
                                    @endforeach  
                                </div>  
                            </div>  
                        </div>  
                    </div>  
                </div>  

                <!-- Footer Actions -->  
                <div class="card-footer bg-light">  
                    <div class="d-flex justify-content-between">  
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">  
                            <i class="fas fa-arrow-left me-2"></i>Kembali  
                        </a>  
                        <div>  
                            <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-warning me-2">  
                                <i class="fas fa-edit me-2"></i>Edit  
                            </a>  
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">  
                                <i class="fas fa-trash me-2"></i>Hapus  
                            </button>  
                        </div>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  

<!-- Delete Confirmation Modal -->  
<div class="modal fade" id="deleteModal" tabindex="-1">  
    <div class="modal-dialog modal-dialog-centered">  
        <div class="modal-content">  
            <div class="modal-header bg-danger text-white">  
                <h5 class="modal-title">Konfirmasi Hapus</h5>  
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>  
            </div>  
            <div class="modal-body">  
                Apakah Anda yakin ingin menghapus paket ini?  
            </div>  
            <div class="modal-footer">  
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>  
                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="d-inline">  
                    @csrf  
                    @method('DELETE')  
                    <button type="submit" class="btn btn-danger">Hapus</button>  
                </form>  
            </div>  
        </div>  
    </div>  
</div>  

<!-- JavaScript Libraries -->  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>  

<!-- Custom JavaScript -->  
<script>  
    document.addEventListener('DOMContentLoaded', function() {  
        // Animasi halus saat modal muncul  
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));  
        
        // Tambahkan konfirmasi tambahan sebelum menghapus  
        const deleteForm = document.querySelector('#deleteModal form');  
        deleteForm.addEventListener('submit', function(e) {  
            const confirmDelete = confirm('Apakah Anda benar-benar yakin? Tindakan ini tidak dapat dibatalkan.');  
            if (!confirmDelete) {  
                e.preventDefault();  
            }  
        });  

        // Efek hover pada tombol  
        const buttons = document.querySelectorAll('.btn');  
        buttons.forEach(button => {  
            button.addEventListener('mouseenter', function() {  
                this.style.transform = 'scale(1.05)';  
            });  
            button.addEventListener('mouseleave', function() {  
                this.style.transform = 'scale(1)';  
            });  
        });  
    });  
</script>  

<!-- Responsive Meta Tag -->  
<meta name="description" content="Detail Paket - Informasi Lengkap Paket Produk">  
<meta name="keywords" content="paket, produk, detail, administrasi">  

<!-- Favicon (Opsional) -->  
<link rel="icon" type="image/png" href="{{ asset('path/to/favicon.png') }}">  

@stack('scripts')  
</body>  
</html>
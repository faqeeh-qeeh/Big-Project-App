<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Daftar Pesanan Client</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">  
</head>  
<body>  
<div class="container-fluid py-4">  
<div class="container mt-5">
    <a href="{{ route('admin.carts.index') }}" class="sidebar-link">
        <i class="bi bi-person-vcard"></i>
        <span>Informasi Akun Client</span>
    </a>
    <!-- Toast Container -->  
    <div class="toast-container position-fixed top-0 end-0 p-3">  
        @if(session('success'))  
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 5;">  
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
                <div class="toast-header bg-dark text-white">  
                    <img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="..." style="width: 1.5rem;">  
                    <strong class="me-auto">Perubahan Produk</strong>  
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>  
                </div>  
                <div class="toast-body">  
                    {{ session('success') }}  
                </div>  
            </div>  
        </div>  
        @endif  

        @if(session('error'))  
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 5;">  
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
                <div class="toast-header bg-dark text-white">  
                    <img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="..." style="width: 1.5rem;">  
                    <strong class="me-auto">Perubahan Produk</strong>  
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>  
                </div>  
                <div class="toast-body">  
                    {{ session('error') }}  
                </div>  
            </div>  
        </div>  
        @endif  
    </div>

    <div class="card shadow-sm">  
        <div class="card-header bg-primary text-white d-flex align-items-center">  
            <i class="bi bi-person-circle me-2"></i>  
            <h4 class="mb-0">Pesanan Client: {{ $client->full_name }}</h4>  
        </div>  
        <div class="card-body">  
            <div class="table-responsive">  
                <table class="table table-striped table-hover">  
                    <thead class="table-light">  
                        <tr>  
                            <th><i class="bi bi-hash me-2"></i>ID Pesanan</th>  
                            <th><i class="bi bi-cash-coin me-2"></i>Total</th>  
                            <th><i class="bi bi-check-circle me-2"></i>Status</th>  
                            <th><i class="bi bi-calendar-date me-2"></i>Tanggal</th>  
                            <th><i class="bi bi-gear me-2"></i>Aksi</th>  
                        </tr>  
                    </thead>  
                    <tbody>  
                        @foreach ($orders as $order)  
                        <tr>  
                            <td>{{ $order->order_id }}</td>  
                            <td>Rp {{ number_format($order->amount, 0, ',', '.') }}</td>  
                            <td>  
                                <span class="badge   
                                    @switch($order->status)  
                                        @case('pending')  
                                            bg-warning text-dark  
                                            @break  
                                        @case('sedang_dikemas')  
                                            bg-info  
                                            @break  
                                        @case('produk_siap')  
                                            bg-success  
                                            @break  
                                        @case('sudah_diambil')  
                                            bg-primary  
                                            @break  
                                        @case('cancel')  
                                            bg-danger  
                                            @break  
                                        @default  
                                            bg-secondary  
                                    @endswitch  
                                ">  
                                    <i class="bi   
                                        @switch($order->status)  
                                            @case('pending')  
                                                bi-clock  
                                                @break  
                                            @case('sedang_dikemas')  
                                                bi-box-seam  
                                                @break  
                                            @case('produk_siap')  
                                                bi-check-circle  
                                                @break  
                                            @case('sudah_diambil')  
                                                bi-bag-check  
                                                @break  
                                            @case('cancel')  
                                                bi-x-circle  
                                                @break  
                                        @endswitch  
                                    me-1"></i>  
                                    {{ App\Models\Order::STATUSES[$order->status] }}  
                                </span>  
                            </td> 
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>  
                            <td>  
                                <form action="{{ route('order.update.status', $order->order_id) }}" method="POST">  
                                    @csrf  
                                    @method('PATCH')  
                                    <div class="input-group">  
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">  
                                            @foreach(App\Models\Order::STATUSES as $key => $label)  
                                                <option value="{{ $key }}"   
                                                    {{ $order->status == $key ? 'selected' : '' }}>  
                                                    {{ $label }}  
                                                </option>  
                                            @endforeach  
                                        </select>  
                                    </div>  
                                </form>  
                            </td>  
                        </tr>  
                        @endforeach  
                    </tbody>  
                </table>  
            </div>  
        </div>  
    </div>
</div>  
</div>  
<script>  
    document.addEventListener('DOMContentLoaded', function() {  
        // Ambil semua toast  
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));  
        
        // Inisialisasi toast  
        var toastList = toastElList.map(function(toastEl) {  
            return new bootstrap.Toast(toastEl);  
        });  

        // Tampilkan toast  
        toastList.forEach(function(toast) {  
            toast.show();  
        });  
    });  
</script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
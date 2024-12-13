@include('admin.layouts.top')
@section('title', $title)
@include('admin.layouts.navbar')

<div class="container mt-5">
    @if(session('success'))
        <div class="position-fixed top-0 end-0 p-3 toast-container">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-dark text-white">
                    <img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="Logo" style="width: 1.5rem;">
                    <strong class="me-auto">Penambahan Produk</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}, bisa cek <a href="{{ route('admin.products.read') }}">di sini</a>.
                </div>
            </div>
        </div>
    @endif

    <h2 class="fw-bold">Tambah Produk</h2>
    <form class="row g-3" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-12">
            <label for="input_id" class="form-label">ID Produk</label>
            <input type="text" class="form-control" id="input_id" name="product_id" required>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header text-white bg-primary">Identitas Produk</h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="input_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="input_nama" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="input_kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="input_kategori" name="category_product" required>
                    </div>
                    <div class="mb-3">
                        <label for="input_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="input_deskripsi" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="inputgambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="inputgambar" name="image" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <h5 class="card-header text-white bg-primary">Aspek Ekonomi</h5>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" class="form-control" id="harga_beli" name="purchase_price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <input type="number" class="form-control" id="harga_jual" name="selling_price" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label for="input_kuantitas" class="form-label">Kuantitas</label>
                            <input type="number" class="form-control" id="input_kuantitas" name="quantity" value="{{ $product->stock->quantity ?? 0 }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-grid">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastElList = Array.from(document.querySelectorAll('.toast'));
        toastElList.forEach(toastEl => new bootstrap.Toast(toastEl, { autohide: false }).show());
    });
</script>

@include('admin.layouts.bot')

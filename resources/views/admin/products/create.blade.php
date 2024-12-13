@extends('admin.layouts.top')
@section ('title', $title)
@include('admin.layouts.navbar')

    <div class="container mt-5" style="{{ $isMobile ? ' margin-left: 15%;' : '' }}"> 
          @if(session('success'))  
          <div class="position-fixed top-0 end-0 p-3" style="z-index: 5; {{ $isMobile ? 'width: 80%;' : '' }}"    >  
              <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
                  <div class="toast-header bg-dark text-white">  
                      <img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="..." style="width: 1.5rem;">  
                      <strong class="me-auto">Penambahan Produk</strong>  
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>  
                  </div>  
                  <div class="toast-body">  
                      {{ session('success') }}, bisa cek <a href="{{ route('admin.products.read') }}">di Sini</a>
                  </div>  
              </div>  
          </div>  
         @endif 

        <h2 class="fw-bold">Tambah Produk</h2>
        <form class="row g-3" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf  

            <div class="col-lg-6">  
              <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">  
                <h5 class="card-header" style="background-color: #1B1A55; color: white;">ID</h5>  
                <div class="card-body">  
                  <div class="row mb-3">  
                    <div class="col-12">
                      <label for="input_id" class="form-label" style="color: #1B1A55;">ID Produk</label>
                      <input type="text" class="form-control" id="input_id" name="product_id" required style="border: 1px solid #1B1A55; border-radius: 5px;">  
                    </div>    
                  </div>  
                </div>  
              </div>
               <br>
              <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">  
                <h5 class="card-header" style="background-color: #FF5F00; color: white;">Aspek Ekonomi</h5>  
                <div class="card-body">  
                  <div class="row mb-3">  
                    <div class="col-md-6">
                      <label for="harga_beli" class="form-label" style="color: #FF5F00;">Harga Beli</label>
                      <input type="number" class="form-control" id="harga_beli" name="purchase_price" step="0.01" required style="border: 1px solid #FF5F00; border-radius: 5px;">  
                    </div>  
                    <div class="col-md-6">
                      <label for="harga_jual" class="form-label" style="color: #FF5F00;">Harga Jual</label>
                      <input type="number" class="form-control" id="harga_jual" name="selling_price" step="0.01" required style="border: 1px solid #FF5F00; border-radius: 5px;">  
                    </div>
                    <div class="col-md-6">
                      <label for="input_kuantitas" class="form-label" style="color: #FF5F00;">Kuantitas</label>
                      <input type="number" class="form-control" id="input_kuantitas" name="quantity" value="{{ $product->stock->quantity ?? 0 }}" required style="border: 1px solid #FF5F00; border-radius: 5px;">  
                    </div>  
                  </div>  
                </div>  
              </div>
              

            </div>


            <div class="col-lg-6">  
              <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">  
                <h5 class="card-header" style="background-color: #00712D; color: white;">Identitas Produk</h5>  
                <div class="card-body">  
                  <div class="row mb-3">  
                    <div class="col-md-6">  
                      <label for="input_nama" class="form-label" style="color: #00712D;">Nama</label>  
                      <input type="text" class="form-control" id="input_nama" name="name" required style="border: 1px solid #00712D; border-radius: 5px;">   
                    </div>  
                    <div class="col-md-6">  
                      <label for="input_kategori" class="form-label" style="color: #00712D;">Kategori</label>  
                      <input type="text" class="form-control" id="input_kategori" name="category_product" required style="border: 1px solid #00712D; border-radius: 5px;">  
                    </div>
                    <div class="col-12">
                      <label for="input_deskripsi" class="form-label" style="color: #00712D;">Deskripsi</label>
                      <textarea class="form-control" id="input_deskripsi" name="description" required style="border: 1px solid #00712D; border-radius: 5px;"></textarea>  
                    </div> 
                    <div class="col-md-12">
                      <label for="inputgambar" class="form-label" style="color: #00712D;">Gambar</label>
                      <input type="file" class="form-control" id="inputgambar" name="image" accept="image/*" style="border: 1px solid #00712D; border-radius: 5px;">  
                    </div> 
                  </div>  
                </div>  
              </div>
              
              <div class="col-12">
                <br>
                <div class="d-grid gap-2 d-md-flex justify-content-end">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>


        </div>  
        </form>
    </div>  
    <script>  
      document.addEventListener('DOMContentLoaded', function () {  
          var toastElList = [].slice.call(document.querySelectorAll('.toast'))  
          var toastList = toastElList.map(function (toastEl) {  
              return new bootstrap.Toast(toastEl, { autohide: false });  
          });  
          toastList.forEach(toast => toast.show());  
      });  
  </script>  
    @include('admin.layouts.bot')
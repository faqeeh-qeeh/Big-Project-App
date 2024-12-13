<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="icon" href="{{ asset('IMG/Logo KM white.png') }}" type="image/png" />
    <title>Ubah Produk</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
      crossorigin="anonymous"
    >
    {{-- <link rel="stylesheet" href="{{ asset('css/navbar/style.css') }}"> --}}
</head>  
<body>  
    <div class="container mt-5" style="{{ $isMobile ? ' padding-top: 0rem;' : '' }}">  
        <h2 class="fw-bold">Ubah Produk</h2>  
        <form class="row g-3" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">  
            @csrf  
            @method('PUT')
            
            <div class="col-lg-6">  
              <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">  
                <h5 class="card-header" style="background-color: #1B1A55; color: white;">ID</h5>  
                <div class="card-body">  
                  <div class="row mb-3">  
                    <div class="col-12">
                      <label for="input_id" class="form-label" style="color: #1B1A55;">ID Produk</label>
                      <input type="text" class="form-control bg-secondary" id="input_id" name="product_id" value="{{ $product->product_id }}" readonly style="border: 1px solid #1B1A55; border-radius: 5px; color: white;">  
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
                      <input type="number" class="form-control" id="harga_beli" name="purchase_price" step="0.01" required style="border: 1px solid #FF5F00; border-radius: 5px;" value="{{ $product->purchase_price }}">  
                    </div>  
                    <div class="col-md-6">
                      <label for="harga_jual" class="form-label" style="color: #FF5F00;">Harga Jual</label>
                      <input type="number" class="form-control" id="harga_jual" name="selling_price" step="0.01" required style="border: 1px solid #FF5F00; border-radius: 5px;" value="{{ $product->selling_price }}">  
                    </div>

                    <div class="col-md-12">
                      
                    </div>
                    <div class="col-md-6">
                      <label for="input_kuantitas" class="form-label" style="color: #FF5F00;">Kuantitas</label>
                      <input type="number" class="form-control" id="input_kuantitas" name="quantity" min="0" required style="border: 1px solid #FF5F00; border-radius: 5px;" value="0">  
                    </div>
                    <div class="col-md-6">
                      <label for="input_aksi" class="form-label" style="color: #FF5F00;">Aksi</label>
                      <br>
                      <select id="input_aksi" class="form-select" name="action" style="width: 100%; height: 50%; border: 1px solid #FF5F00; border-radius: 5px; ">
                        <option value="add" selected >Tambah Stok</option>
                        <option value="subtract">Kurangi Stok</option>
                      </select>
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
                      <input type="text" class="form-control" id="input_nama" name="name" required style="border: 1px solid #00712D; border-radius: 5px;" value="{{ $product->name }}">   
                    </div>  
                    <div class="col-md-6">  
                      <label for="input_kategori" class="form-label" style="color: #00712D;">Kategori</label>  
                      <input type="text" class="form-control" id="input_kategori" name="category_product" required style="border: 1px solid #00712D; border-radius: 5px;" value="{{ $product->category_product }}">  
                    </div>
                    <div class="col-12">
                      <label for="input_deskripsi" class="form-label" style="color: #00712D;">Deskripsi</label>
                      <textarea class="form-control" id="input_deskripsi" name="description" required style="border: 1px solid #00712D; border-radius: 5px;">{{ $product->description }}</textarea>  
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
                  <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
              </div>
            </div>

        </form>
        @if(session('success'))  
            <div class="alert alert-success">{{ session('success') }}</div>  
        @endif  
        @if(session('error'))  
            <div class="alert alert-danger">{{ session('error') }}</div>  
        @endif
    </div>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>  
</html>
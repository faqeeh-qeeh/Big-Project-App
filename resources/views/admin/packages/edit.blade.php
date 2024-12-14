@extends('admin.layouts.top')
@section ('title', $title)
@include('admin.layouts.navbar')

<div class="container mt-5" style="padding-left: 6rem; padding-right: 6rem;">  
    <h2 class="fw-bold"><i class="bi bi-box-seam"></i> Edit Paket</h2>
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" id="packageForm" class="row g-3">  
        @csrf  
        @method('PUT')
        <div class="col-lg-6">
            <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-header" style="background-color: #2B3499; color: white;">  
                    Informasi Paket  
                </div>  
                <div class="card-body">  
                    <div class="form-group">  
                        <label>Nama Paket</label>  
                        <input   
                            type="text"   
                            class="form-control @error('name') is-invalid @enderror"   
                            name="name"   
                            value="{{ old('name', $package->name) }}"  
                            required  
                        >  
                        @error('name')  
                            <div class="invalid-feedback">{{ $message }}</div>  
                        @enderror  
                    </div>  
    
                    <div class="form-group">  
                        <label>Deskripsi Paket</label>  
                        <textarea   
                            class="form-control"   
                            name="description"   
                            rows="3"  
                        >{{ old('description', $package->description) }}</textarea>  
                    </div>  
                </div>
            </div>
            <br>
            <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
                <div class="card-header" style="background-color: #FF6C22; color: white;">  
                    Ringkasan Paket  
                </div>  
                <div class="card-body">  
                    <div class="form-group">  
                        <label>Estimasi Total Harga</label>  
                        <input   
                            type="text"   
                            class="form-control"   
                            id="totalPriceDisplay"   
                            readonly  
                            value="Rp {{ number_format($package->total_price, 0, ',', '.') }}"  
                        >  
                    </div>  
                </div>  
            </div> 
            <button type="submit" class="btn btn-primary mt-3">  
                Simpan Perubahan  
            </button>
        </div>
          
        <div class="col-lg-6">
            <div class="card" style="box-shadow: 0 4px 20px rgba(0,0,0,0.2);">  
                <div class="card-header" style="background-color: #3C5B6F; color: white;">  
                    Pilih Produk untuk Paket  
                    <button type="button" class="btn btn-sm btn-success float-right" id="addProductBtn">  
                        + Tambah Produk  
                    </button>  
                </div>  
                <div class="card-body" id="productContainer">  
                    <!-- Produk akan ditambahkan secara dinamis -->  
                    @foreach($package->products as $index => $product)
                        <div class="product-item row mb-3">  
                            <div class="col-md-6" style="padding-right: 10px;">
                                <select
                                    name="products[]"
                                    class="form-control product-select select2-dynamic"
                                    style="width: 100%; border-radius: 4px; padding: 5px; font-size: 14px;"
                                    data-placeholder="Cari Produk"
                                    required
                                >
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $availableProduct)
                                        <option 
                                            value="{{ $availableProduct->id }}" 
                                            data-price="{{ $availableProduct->selling_price }}"
                                            {{ $product->id == $availableProduct->id ? 'selected' : '' }}
                                        >
                                            {{ $availableProduct->name }} (Rp {{ number_format($availableProduct->selling_price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4">  
                                <input   
                                    type="number"   
                                    name="quantities[]"   
                                    class="form-control"   
                                    placeholder="Jumlah"   
                                    value="{{ $product->pivot->quantity }}"  
                                    min="1"  
                                    required  
                                >  
                            </div>  
                            <div class="col-md-2" style="padding-left: 5px;">
                                <button type="button" class="btn btn-danger remove-product" style="width: 100%; height: 38px; font-size: 14px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>                                  
                        </div>  
                    @endforeach  
                </div>  
            </div>
        </div>
    </form>  
</div>  
@push('scripts')  
<script>  
document.addEventListener('DOMContentLoaded', function() {  
    const productContainer = document.getElementById('productContainer');  
    const addProductBtn = document.getElementById('addProductBtn');  
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');  
    const products = @json($products);  

    // Inisialisasi Select2 untuk dropdown produk yang sudah ada  
    $('.select2-dynamic').select2({  
        templateResult: formatProduct,  
        templateSelection: formatProductSelection,  
        matcher: matchCustom  
    });  

    // Fungsi format tampilan produk di dropdown  
    function formatProduct(product) {  
        if (!product.id) return product.text;  
        var $product = $(  
            `<span>${product.text}</span>`  
        );  
        return $product;  
    }  

    // Fungsi format seleksi produk  
    function formatProductSelection(product) {  
        return product.text;  
    }  

    // Custom matcher untuk pencarian  
    function matchCustom(params, data) {  
        // Jika tidak ada pencarian, tampilkan semua  
        if ($.trim(params.term) === '') {  
            return data;  
        }  

        // Cek apakah text cocok (case insensitive)  
        if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {  
            return data;  
        }  

        return null;  
    }  

    // Fungsi untuk membuat elemen produk baru  
    function createProductElement() {  
        const div = document.createElement('div');  
        div.classList.add('product-item', 'row', 'mb-3');  
        div.innerHTML = `
                <div class="col-md-6" style="padding-right: 10px;">
                    <select
                        name="products[]"
                        class="form-control product-select select2-dynamic"
                        style="width: 100%; border-radius: 4px; padding: 5px; font-size: 14px;"
                        data-placeholder="Cari Produk"
                        required
                    >
                        <option value="">Pilih Produk</option>
                        ${products.map(product => `
                            <option
                                value="${product.id}"
                                data-price="${product.selling_price}"
                            >
                                ${product.name} (Rp ${product.selling_price.toLocaleString()})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="col-md-4" style="padding-right: 10px;">
                    <input
                        type="number"
                        name="quantities[]"
                        class="form-control"
                        style="width: 100%; border-radius: 4px; padding: 5px; font-size: 14px;"
                        placeholder="Jumlah"
                        min="1"
                        required
                    >
                </div>
                <div class="col-md-2" style="padding-left: 5px;">
                    <button type="button" class="btn btn-danger remove-product" style="width: 100%; height: 38px; font-size: 14px;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;


        // Tambah event listener untuk tombol hapus  
        $(document).on('click', '.remove-product', function() {  
            console.log('Tombol hapus diklik');  
            $(this).closest('.product-item').remove();  
            calculateTotalPrice();  
        });

        // Inisialisasi Select2 untuk dropdown baru  
                // Inisialisasi Select2 untuk dropdown baru  
                $(div).find('.select2-dynamic').select2({  
            templateResult: formatProduct,  
            templateSelection: formatProductSelection,  
            matcher: matchCustom  
        });  

        // Tambah event listener untuk perubahan produk  
        $(div).find('.product-select').on('change', calculateTotalPrice);  
        $(div).find('input[name="quantities[]"]').on('input', calculateTotalPrice);  

        return div;  
    }  

    // Tambah produk baru  
    addProductBtn.addEventListener('click', function() {  
        const newProductElement = createProductElement();  
        productContainer.appendChild(newProductElement);  
    });  

    // Fungsi hitung total harga  
    function calculateTotalPrice() {  
        let totalPrice = 0;  
        const productItems = document.querySelectorAll('.product-item');  

        productItems.forEach(item => {  
            const productSelect = $(item).find('.product-select');  
            const quantityInput = $(item).find('input[name="quantities[]"]');  
            
            if (productSelect.val() && quantityInput.val()) {  
                const selectedProduct = products.find(p => p.id == productSelect.val());  
                totalPrice += selectedProduct.selling_price * parseInt(quantityInput.val());  
            }  
        });  

        // Tampilkan total harga dengan format rupiah  
        totalPriceDisplay.value = `Rp ${totalPrice.toLocaleString()}`;  
    }  

    // Inisialisasi event listener untuk elemen yang sudah ada  
    $(document).on('change', '.product-select, input[name="quantities[]"]', calculateTotalPrice);  

    // Hitung total harga awal  
    calculateTotalPrice();  
});



</script>  
@include('admin.layouts.bot')

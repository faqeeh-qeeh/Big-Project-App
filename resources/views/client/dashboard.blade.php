<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Client Dashboard</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
    <style>  
        body {  
            background-color: #f4f6f9;  
        }  
        .dashboard-container {  
            background-color: white;  
            border-radius: 12px;  
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);  
            padding: 30px;  
            margin-top: 30px;  
        }  
        .profile-header {  
            display: flex;  
            align-items: center;  
            margin-bottom: 30px;  
            background-color: #068FFF;  
            color: white;  
            padding: 15px;  
            border-radius: 8px;  
        }  
        .profile-header img {  
            margin-right: 15px;  
            border-radius: 50%;  
        }  
        .profile-info p {  
            margin-bottom: 10px;  
            color: #555;  
        }  
        .orders-table {  
            margin-top: 30px;  
        }  
    </style>  
</head>  
<body>  
<div class="container mt-5"> 
    
    <nav
    class="navbar navbar-expand-lg"
    style="background-color: #068fff"
    data-bs-theme="dark"
  >
    <div class="container-fluid">
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse"
        id="navbarNavAltMarkup"
        style="font-weight: 600"
      >
        <div class="navbar-nav">
          <a class="nav-link" aria-current="page" href="{{ route('cart.index') }}"
            ><i class="bi bi-cart-check-fill"> Keranjang Belanja</i></a
          >
          <a class="nav-link active" href="#"
            ><i class="bi bi-person-circle"> Biodata</i></a
          >
          <form action="{{ route('client.logout') }}" method="POST">  
            @csrf  
            <button class="nav-link" type="submit">
              <i class="bi bi-box-arrow-right"> Logout</i></button>  
          </form>  
          <a class="nav-link" href="/kanjeng-mami/products"
            ><i class="bi bi-back"> Kembali ke Daftar Produk</i></a
          >
        </div>
      </div>
      <img
        src="{{ asset('img/Logo KM white.png') }}"
        alt=""
        width="{{ $isMobile ? '70px' : '20px' }}"
      />
    </div>
  </nav>
    <div class="dashboard-container">  
        <div class="profile-header">  
            <div>  
                <h2 class="mb-2">Welcome, {{ $client->full_name }}</h2>  
                <p class="text-light mb-0">Selamat datang di dashboard Anda</p> 
                <a href="{{ route('client.edit-profile') }}" class="text-white ms-2">  
                    <i class="bi bi-pencil-square"></i> Edit Profil  
                </a> 
            </div>  
        </div>  

        <div class="row profile-info">     
            <div class="col-md-6">  
                <p><strong>Username:</strong> {{ $client->username }}</p>  
                <p><strong>Email:</strong> {{ $client->email }}</p>  
                <p><strong>Tanggal Lahir:</strong> {{ $client->birth_date }}</p>  
            </div>  
            <div class="col-md-6">  
                <p><strong>Alamat:</strong> {{ $client->address }}</p>  
                <p><strong>No. Telepon:</strong> {{ $client->phone }}</p>  
                <p><strong>Jenis Kelamin:</strong> {{ $client->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>  
            </div>  
        </div>  

        <div class="orders-table">  
            <h3 class="mb-3">Riwayat Pesanan</h3>  
            <div class="table-responsive">  
                <table class="table table-striped table-hover">  
                    <thead class="table-primary">  
                        <tr>  
                            <th>ID Pesanan</th>  
                            <th>Total</th>  
                            <th>Status</th>  
                            <th>Tanggal</th>  
                        </tr>  
                    </thead>  
                    <tbody>  
                        @foreach ($client->orders as $order)  
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
                        </tr>  
                        @endforeach  
                    </tbody>  
                </table>  
            </div>  
        </div>  
    </div>  
</div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
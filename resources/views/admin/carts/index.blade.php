@include('admin.layouts.top')  
@section('title', $title)  
@include('admin.layouts.navbar')  
<div class="container mt-4">  
    <h2 style="font-weight: 900;">Daftar Keranjang Client</h2>  
    
    <!-- Form Pencarian -->  
    <form method="GET" action="{{ route('admin.carts.index') }}" class="mb-4">  
        <div class="input-group">  
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau email" value="{{ request('search') }}">  
            <button class="btn btn-primary" type="submit">Cari</button>  
        </div>  
    </form>  

    @if($clients->isEmpty())  
    <div class="table-responsive">  
        <table class="table table-bordered table-striped table-hover">  
            <thead class="sticky-top" style="background-color: #4e4feb; color: #fff; z-index: 4">  
                <tr class="text-center">  
                    <th>#</th>  
                    <th>Username</th>  
                    <th>Email</th>  
                    <th>Total Produk</th>  
                    <th>Aksi</th>  
                </tr>  
            </thead>  
            <tbody>  
                <tr>  
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-person-x fa-3x mb-3"></i>                        
                        <p>tidak ada client yang terdaftar</p>
                      </td>                
                    </tr>
            </tbody>   
        </table>  
    </div>  
    @else  
        <div class="table-responsive">  
            <table class="table table-bordered table-striped table-hover">  
                <thead class="sticky-top" style="background-color: #4e4feb; color: #fff; z-index: 4">  
                    <tr class="text-center">  
                        <th>#</th>  
                        <th>Username</th>  
                        <th>Email</th>  
                        <th>Total Produk</th>  
                        <th>Aksi</th>  
                    </tr>  
                </thead>  
                <tbody>  
                    @foreach ($clients as $client)  
                        <tr>  
                            <td class="text-center">{{ $loop->iteration }}</td>  
                            <td>{{ $client->username }}</td>  
                            <td>{{ $client->email }}</td>  
                            <td class="text-center">{{ $client->carts->sum('quantity') }}</td>  
                            <td class="text-center">  
                                <a href="{{ route('admin.carts.show', $client->id) }}" style="background-color: #52057B" class="btn btn-sm text-white"><i class="bi bi-cart3"></i></a>   
                                <button   
                                    type="button"   
                                    class="btn btn-sm text-white"  
                                    style="background-color: #0D7377"   
                                    data-bs-toggle="modal"   
                                    data-bs-target="#staticBackdrop"  
                                    data-username="{{ $client->username }}"  
                                    data-full_name="{{ $client->full_name }}"  
                                    data-email="{{ $client->email }}"  
                                    data-birthdate="{{ $client->birth_date }}"  
                                    data-address="{{ $client->address }}"  
                                    data-phone="{{ $client->phone }}"  
                                    data-gender="{{ $client->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}">  
                                    <i class="bi bi-person-bounding-box"></i>  
                                </button>  

                                <a href="{{ route('admin.carts.orders', $client->id) }}" style="background-color: #323232" class="btn btn-sm text-white position-relative">  
                                    <i class="bi bi-credit-card"></i>  
                                    @php  
                                        $priorityOrder = ['cancel', 'sudah_diambil', 'produk_siap', 'sedang_dikemas', 'pending'];  
                                        $orderStatuses = $client->orders()  
                                            ->select('status', \DB::raw('count(*) as total'))  
                                            ->groupBy('status')  
                                            ->get()  
                                            ->sortBy(function ($item) use ($priorityOrder) {  
                                                return array_search($item->status, $priorityOrder);  
                                            }, SORT_REGULAR, true);  
                                    @endphp  

                                    @php $badgeDisplayed = false; @endphp  

                                    @foreach($orderStatuses as $orderStatus)  
                                        @if(!$badgeDisplayed)  
                                            @switch($orderStatus->status)  
                                                @case('pending')  
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">  
                                                        {{ $orderStatus->total }}  
                                                        <span class="visually-hidden">Pesanan Pending</span>  
                                                    </span>  
                                                    @php $badgeDisplayed = true; @endphp  
                                                    @break  
                                                @case('sedang_dikemas')  
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">  
                                                        {{ $orderStatus->total }}  
                                                        <span class="visually-hidden">Pesanan Sedang Dikemas</span>  
                                                    </span>  
                                                    @php $badgeDisplayed = true; @endphp  
                                                    @break  
                                                @case('produk_siap')  
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">  
                                                        {{ $orderStatus->total }}  
                                                        <span class="visually-hidden">Pesanan Produk Siap</span>  
                                                    </span>  
                                                    @php $badgeDisplayed = true; @endphp  
                                                    @break  
                                                @case('sudah_diambil')  
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">  
                                                        {{ $orderStatus->total }}  
                                                        <span class="visually-hidden">Pesanan Sudah Diambil</span>  
                                                    </span>  
                                                    @php $badgeDisplayed = true; @endphp  
                                                    @break  
                                                @case('cancel')  
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">  
                                                        {{ $orderStatus->total }}  
                                                        <span class="visually-hidden">Pesanan Dibatalkan</span>  
                                                    </span>  
                                                    @php $badgeDisplayed = true; @endphp  
                                                    @break  
                                            @endswitch  
                                        @endif  
                                    @endforeach  
                                </a>  
                            </td>  
                        </tr>  
                    @endforeach  
                </tbody>   
            </table>  
        </div>  
    @endif  
</div> 
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> 
  <script>  
    document.addEventListener('DOMContentLoaded', function() {  
        const myModal = document.getElementById('staticBackdrop');  
        myModal.addEventListener('show.bs.modal', function(event) {  
            const button = event.relatedTarget; // Tombol yang diklik  
            const username = button.getAttribute('data-username');  
            const full_name = button.getAttribute('data-full_name');  
            const email = button.getAttribute('data-email');  
            const birthdate = button.getAttribute('data-birthdate');  
            const address = button.getAttribute('data-address');  
            const phone = button.getAttribute('data-phone');  
            const gender = button.getAttribute('data-gender'); // Mengambil jenis kelamin dari data  

            // Update konten modal dengan data yang diambil dari tombol  
            const modalTitle = myModal.querySelector('.modal-title');  
            const modalBody = myModal.querySelector('.modal-body');  

            modalTitle.textContent = `Profil ${username}`;  
            modalBody.innerHTML = `  
            <table class="table table">  
                <tbody>  
                    <tr>  
                        <th scope="row">Username</th>  
                        <td>: ${username}</td>  
                    </tr>  
                    <tr>  
                        <th scope="row">Nama Panjang</th>  
                        <td>: ${full_name}</td>  
                    </tr>  
                    <tr>  
                        <th scope="row">Email</th>  
                        <td>: ${email}</td>  
                    </tr>  
                    <tr>  
                        <th scope="row">Tanggal Lahir</th>  
                        <td>: ${birthdate}</td>  
                    </tr>  
                    <tr>  
                        <th scope="row">Alamat</th>  
                        <td>: ${address}</td>  
                    </tr>  
                    <tr>  
                        <th scope="row">Nomer Telepon</th>  
                        <td>: ${phone}</td>  
                    </tr>  
                    <tr>  
                        <th scope="row">Jenis Kelamin</th>  
                        <td>: ${gender}</td> <!-- Menggunakan data gender yang sudah diambil -->  
                    </tr>  
                </tbody>  
            </table>  
            `;  
        });  
    });  
</script>
@include('admin.layouts.bot')
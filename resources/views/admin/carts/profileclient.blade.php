@include('admin.layouts.top')  
@section('title', $title)  
@include('admin.layouts.navbar')   

<div class="container mt-4">  
    <div class="card shadow-lg">  
        <div class="card-header text-center">  
            <h2 style="font-weight: 900;">Detail Profil: {{ $client->username }}</h2>  
        </div>  
        <div class="card-body">  
            <ul class="list-group list-group-flush">  
                <li class="list-group-item"><strong>Username:</strong> {{ $client->username }}</li>  
                <li class="list-group-item"><strong>Email:</strong> {{ $client->email }}</li>  
                <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ $client->birth_date }}</li>  
                <li class="list-group-item"><strong>Alamat:</strong> {{ $client->address }}</li>  
                <li class="list-group-item"><strong>Nomor Telepon:</strong> {{ $client->phone }}</li>  
                <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $client->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</li>  
            </ul>  
        </div>  
    </div>  
</div>  

@include('admin.layouts.bot')
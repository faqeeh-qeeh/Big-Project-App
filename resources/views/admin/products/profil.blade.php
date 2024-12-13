<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Admin Dashboard</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
</head>  
<body>  
<div class="container mt-5">  
    <div class="d-flex justify-content-between align-items-center mb-4">  
        <h2></h2>  
        <h2 class="fw-bold">Admin Dashboard</h2>
        <!-- Logout Button -->  
        <form action="{{ route('admin.logout') }}" method="POST">  
            @csrf  
            <button type="submit" class="btn btn-danger">Logout</button>  
        </form>  
    </div>  

    <h4>Registered Clients</h4>  
    <table class="table table-bordered">  
        <thead>  
            <tr>  
                <th>ID</th>  
                <th>Full Name</th>  
                <th>Username</th>  
                <th>Email</th>  
                <th>Birth Date</th>  
                <th>Address</th>  
            </tr>  
        </thead>  
        <tbody>  
            @foreach ($clients as $client)  
            <tr>  
                <td>{{ $client->id }}</td>  
                <td>{{ $client->full_name }}</td>  
                <td>{{ $client->username }}</td>  
                <td>{{ $client->email }}</td>  
                <td>{{ $client->birth_date }}</td>  
                <td>{{ $client->address }}</td>  
            </tr>  
            @endforeach  
        </tbody>  
    </table>  
</div>  
</body>  
</html>
<!-- resources/views/layouts/app.blade.php -->  
<!DOCTYPE html>  
<html>  
<head>  
    <title>Sensor Monitoring</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
</head>  
<body>  
    @yield('content')  
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>  
    @stack('scripts')  
</body>  
</html>
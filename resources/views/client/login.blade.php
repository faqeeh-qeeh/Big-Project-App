<!DOCTYPE html>  
<html lang="en">  
<head>  
	<meta charset="utf-8">  
	<meta name="author" content="Muhamad Nauval Azhar">  
	<meta name="viewport" content="width=device-width,initial-scale=1">  
	<meta name="description" content="This is a login page template based on Bootstrap 5">  
	<title>Login User</title>  
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">  
	<style>
	#logo {
        animation: atas-bawah 1s ease-out; 
    }
    @keyframes atas-bawah {  
        from {  
            transform: translateY(-100%);  
        }  
        to {  
            transform: translateY(0);  
        }  
    } 
	</style>
</head>  
<body style="background-color: #4e4feb">  

	{{-- @if (session('success'))  
<div class="alert alert-success" role="alert">  
    {{ session('success') }}  
</div>  
@endif --}}
@if(session('success'))  
<div class="position-fixed top-0 end-0 p-3" style="z-index: 5;"    >  
	<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">  
		<div class="toast-header bg-dark text-white">  
			<img src="{{ asset('img/Logo KM.png') }}" class="rounded me-2" alt="..." style="width: 1.5rem;">  
			<strong class="me-auto">Berhasil</strong>  
			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>  
		</div>  
		<div class="toast-body">  
			{{ session('success') }}  
		</div>  
	</div>  
</div>  
@endif  

	<section class="h-100">  
		<div class="container h-100">  
			<div class="row justify-content-sm-center h-100">  
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">  
                    <div class="text-center my-5" id="logo">  
						<img src="{{ asset('img/Logo KM white.png') }}" alt="logo" width="70">  
					</div>  
					<div class="card shadow-lg" id="form">  
						<div class="card-body p-5">  
							<h1 class="fs-4 card-title fw-bold mb-4">Login User</h1>  
                            @if ($errors->any())  
								@foreach ($errors->all() as $error) 
								<span style="color: red;text-align: center">{{ $error }}</span>
								@endforeach  
                            @endif  

							<form method="POST" action="{{ url('client/login') }}" autocomplete="off">  
								@csrf  
								<div class="mb-3">  
									<label class="mb-2 text-muted" for="username">Username</label>  
									<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>  
								</div>  

                                <div class="mb-3">  
                                    <div class="mb-2 w-100">  
										<label class="text-muted" for="password">Password</label>  
									</div>  
                                    <div class="input-group">  
                                        <input type="password" class="form-control" name="password" id="password" required>  
                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword1">  
                                            <i class="bi bi-eye-slash" id="eyeIcon1"></i>  
                                        </button>  
                                    </div>  
                                </div>  

								<div class="d-flex align-items-center">  
									<button type="submit" class="btn btn-primary ms-auto">  
										Login  
									</button>  
								</div>  
							</form>  
						</div>  
						<div class="card-footer py-3 border-0" style="background-color: #EEEEEE">  
							<div class="text-center">  
								Belum punya akun? <a href="{{ route('client.register') }}" class="text-dark">Daftarkan disini</a>  
							</div>  
						</div>  
					</div>  
				</div>  
			</div>  
		</div>  
	</section>  

	<script>  
        const togglePassword1 = document.getElementById('togglePassword1');  
        const passwordInput1 = document.getElementById('password');  
        const eyeIcon1 = document.getElementById('eyeIcon1');  
    
        togglePassword1.addEventListener('click', function () {  
            const type = passwordInput1.getAttribute('type') === 'password' ? 'text' : 'password';  
            passwordInput1.setAttribute('type', type);  
            eyeIcon1.classList.toggle('bi-eye');  
            eyeIcon1.classList.toggle('bi-eye-slash');  
        });  
    </script> 
	 <script>  
		document.addEventListener('DOMContentLoaded', function () {  
			var toastElList = [].slice.call(document.querySelectorAll('.toast'))  
			var toastList = toastElList.map(function (toastEl) {  
				return new bootstrap.Toast(toastEl, { autohide: false });  
			});  
			toastList.forEach(toast => toast.show());  
		});  
	</script> 
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous">
	</script>
</body>  
</html>
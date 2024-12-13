<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Client Register</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />  
    <style>
    @keyframes kiri-kanan {  
        from {  
            transform: translateX(150%);  
        }  
        to {  
            transform: translateX(0);  
        }  
    }  

    #detail {  
        animation: kiri-kanan 1.3s ease-out;  
    }
    /* #form {
        animation: kanan-kiri 1s ease-out; 
    }
    @keyframes kanan-kiri {  
        from {  
            transform: translateX(100%);  
        }  
        to {  
            transform: translateX(0);  
        }  
    }  */
    </style>
</head>  
<body>  
<section class=" py-3 py-md-5 py-xl-8" style="background-color: #4e4feb">  
    <div class="container">  
        <div class="row gy-4 align-items-center" style="background-color: #4e4feb">  
            <div class="col-12 col-md-6 col-xl-5">  
                <div class="d-flex justify-content-center" style="background-color: #4e4feb">  
                    <div class="col-12 col-xl-9" id="detail">  
                        <img class="img-fluid rounded mb-4" loading="lazy" src="{{ asset('img/Logo KM white.png') }}" width="45" height="80" alt="BootstrapBrain Logo">  
                        <hr class="border-primary-subtle mb-4">  
                        <h2 class="h1 mb-4" style="color: white">Banyak Keuntungan untuk mendaftar akun anda</h2>  
                        <p class="lead mb-5" style="color: white">Kamu bisa menyimpan sebuah produk ke Keranjangmu.  
                            <br>  
                            kamu bisa <a href="/kanjeng-mami/products" style="color: white; text-decoration: none;"><b>Kembali</b></a> jika mau.  
                        </p>
                    </div>  
                </div>  
            </div>  
            <div class="col-12 col-md-6 col-xl-7">  
                <div class="card border-0 rounded-4" id="form">  
                    <div class="card-body p-3 p-md-4 p-xl-5">  
                        <div class="row">  
                            <div class="col-12">  
                                <div class="mb-4">  
                                    <h2 class="h3">Registration</h2>  
                                    <h3 class="fs-6 fw-normal text-secondary m-0">Masukkan Detail Akun</h3>  
                                </div>  
                            </div>  
                        </div>  

                    
                    <form action="{{ url('client/register') }}" method="POST">  
                        @csrf  
                        <div class="row gy-3 overflow-hidden">  
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Nama Panjang" required value="{{ old('full_name') }}">  
                                    <label for="full_name">Nama Panjang</label>  
                                </div>  
                            </div>  
                            <div class="col-6">  

                                <div class="form-floating">  
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required value="{{ old('username') }}">  
                                    <label for="username">Username</label>  
                                </div>
                                @if ($errors->has('username'))  
                                <div class="text-danger">  
                                    {{ $errors->first('username', 'username telah digunakan') }}  
                                </div>  
                                @endif    
                            </div>  
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required value="{{ old('email') }}">  
                                    <label for="email">Email</label>  
                                </div>  
                            </div>  
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <input type="date" class="form-control" name="birth_date" id="birth_date" required value="{{ old('birth_date') }}">  
                                    <label for="birth_date">Tanggal Lahir</label>  
                                </div>  
                            </div> 
                            
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <select class="form-select" name="gender" id="gender" required>  
                                        <option value="">Pilih Jenis Kelamin</option>  
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>  
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>  
                                    </select>  
                                    <label for="gender">Jenis Kelamin</label>  
                                </div>  
                            </div>  
                        
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <div class="input-group">  
                                        <span class="input-group-text">+62</span>  <!-- Prefix untuk nomor telepon -->  
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Nomor Telepon" required value="{{ old('phone') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">  
                                    </div>  
                                </div>  
                            </div>
        
                            <div class="col-12">  
                                <div class="form-floating">  
                                    <textarea class="form-control" name="address" id="address" placeholder="Address" required>{{ old('address') }}</textarea>  
                                    <label for="address">Alamat Rumah</label>  
                                </div>  
                            </div>  
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>  
                                    <label for="password">Password</label>  
                                </div>  
                                @if ($errors->has('password'))  
                                <div class="text-danger">  
                                    {{ $errors->first('password', 'Password harus lebih dari 8 karakter') }}  
                                </div>  
                                @endif  
                            </div>  
                            <div class="col-6">  
                                <div class="form-floating">  
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>  
                                    <label for="password_confirmation">Konfirmasi Password</label>  
                                </div>  
                                @if ($errors->has('password'))  
                                    <div class="text-danger">  
                                        {{ $errors->first('password', 'Password tidak cocok') }}  
                                    </div>  
                                @endif  
                            </div>  
                            <div class="col-6">  
                                <div class="form-check">  
                                    <input class="form-check-input" type="checkbox" onclick="togglePasswordVisibility()">  
                                    <label class="form-check-label" for="show_password">Tampilkan Password</label>  
                                </div>  
                            </div>  
                            <div class="col-12">  
                                <div class="d-grid">  
                                    <button class="btn btn-primary btn-lg" type="submit">Daftar</button>  
                                </div>  
                            </div>  
                        </div>  
                    </form>  


                        <div class="row">  
                            <div class="col-12">  
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">  
                                    <p class="m-0 text-secondary text-center">Sudah punya akun? <a href="{{ route('client.login') }}" class="link-primary text-decoration-none">Masuk</a></p>  
                                </div>  
                            </div>  
                        </div>  
                    </div>  
                </div>  
            </div>  
        </div>  
    </div>  
</section>
                    
<script>  
    function togglePasswordVisibility() {  
        const password = document.getElementById('password');  
        const passwordConfirmation = document.getElementById('password_confirmation');  
        if (password.type === 'password') {  
            password.type = 'text';  
            passwordConfirmation.type = 'text';  
        } else {  
            password.type = 'password';  
            passwordConfirmation.type = 'password';  
        }  
    }  
</script>  
<script>
        var prefix = "+62"; // Prefix untuk nomor telepon  

        document.getElementById('phone').addEventListener('input', function() {  
            // Menghapus semua karakter kecuali angka  
            this.value = this.value.replace(/[^0-9]/g, '');  
        });  
        
        document.querySelector('form').addEventListener('submit', function(event) {  
            var phoneField = document.getElementById('phone');  
            // Jika nilai input tidak kosong, tambahkan prefix  
            if (phoneField.value) {  
                phoneField.value = prefix + phoneField.value;  
            }  
        });  
</script>
</body>  
</html>
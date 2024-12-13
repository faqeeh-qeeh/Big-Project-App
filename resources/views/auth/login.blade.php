<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="{{ asset('IMG/Logo KM white.png') }}" type="image/png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="css/content/login.css" />
    <title>Halaman Admin</title>
    <script>  
      function togglePasswordVisibility() {  
          const passwordInput = document.getElementById('password');  
          const passwordToggleButton = document.getElementById('togglePassword');  

          // Toggle the type attribute  
          if (passwordInput.type === 'password') {  
              passwordInput.type = 'text';  
              passwordToggleButton.textContent = 'Sembunyikan';  
          } else {  
              passwordInput.type = 'password';  
              passwordToggleButton.textContent = 'Tampilkan';  
          }  
      }  
    </script>  


  </head>
  <body>
    <!----------------------- Main Container -------------------------->

    <div
      class="container d-flex justify-content-center align-items-center min-vh-100"
    >
      <!----------------------- Login Container -------------------------->

      <div class="row border rounded-5 p-3 bg-white shadow box-area">
        <!--------------------------- Left Box ----------------------------->

        <div
          class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box logo1"
          style="background: #068fff"
        >
          <div class="featured-image mb-3">
            <img
              src="img/Logo KM white.png"
              class="img-fluid"
              style="width: 250px"
            />
          </div>
          <p class="text-white fs-2" style="font-weight: 600">KANJENG MAMI</p>
          <small
            class="text-white text-wrap text-center"
            style="width: 15rem; font-family: 'Courier New', Courier, monospace"
            >Toko Fotocopy</small
          >
        </div>

        <!-------------------- ------ Right Box ---------------------------->

        <div class="col-md-6 right-box">
          <div class="row align-items-center">
            <div class="header-text mb-4">
              <h2>Hello, Admin</h2>
              <p>Selamat datang kembali</p>
            </div>
            <!-- <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Username"
              />
            </div>
            <div class="input-group mb-1">
              <input
                type="password"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Password"
              />
            </div> -->
            <form method="POST" action="{{ url('admin/login') }}">  
              @csrf  
              <div class="mb-3">  
                  <label for="email" class="form-label">Email :</label>  
                  <input type="email" class="form-control form-control-lg bg-light fs-6" placeholder="email anda" id="email" value="{{ old('email') }}" name="email" required>  
                  @error('email')  
                    <div class="text-danger">{{ $message }}</div>  
                  @enderror  
              </div>  
              <div class="mb-3">  
                  <label for="password" class="form-label">Password :</label>  
                  <div class="input-group">  
                    <input type="password" class="form-control" name="password" id="password" required>  
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword" onclick="togglePasswordVisibility()">Tampilkan</button>  
                  </div>               
                </div>
                @error('password')  
                  <div class="text-danger">{{ $message }}</div>  
                @enderror 
              <div class="input-group mb-3">
                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
              </div>  
          </form>  
            {{-- <div class="input-group mb-3">
              <button class="btn btn-lg btn-light w-100 fs-6">
                <i class="bi bi-google"></i>
                <small>Sign In with Google</small>
              </button>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

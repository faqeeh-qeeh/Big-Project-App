<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Edit Profil</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">  
    <style>  
        :root {  
            --primary-color: #6a11cb;  
            --secondary-color: #2575fc;  
            --bg-light: #f4f6f9;  
        }  

        body {  
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));  
            font-family: 'Inter', sans-serif;  
            min-height: 100vh;  
            display: flex;  
            align-items: center;  
        }  

        .profile-container {  
            background: white;  
            border-radius: 20px;  
            box-shadow: 0 15px 35px rgba(50,50,93,.1), 0 5px 15px rgba(0,0,0,.07);  
            padding: 40px;  
            max-width: 800px;  
            width: 100%;  
            margin: auto;  
            position: relative;  
            overflow: hidden;  
        }  

        .profile-container::before {  
            content: '';  
            position: absolute;  
            top: 0;  
            left: 0;  
            width: 100%;  
            height: 6px;  
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));  
        }  

        .form-label {  
            font-weight: 600;  
            color: #6c757d;  
            margin-bottom: 0.5rem;  
        }  

        .form-control, .form-select {  
            border-radius: 10px;  
            padding: 12px 15px;  
            border-color: #e9ecef;  
        }  

        .form-control:focus, .form-select:focus {  
            border-color: var(--primary-color);  
            box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.25);  
        }  

        .btn-primary {  
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));  
            border: none;  
            transition: transform 0.3s ease;  
        }  

        .btn-primary:hover {  
            transform: scale(1.05);  
            background: linear-gradient(to right, var(--secondary-color), var(--primary-color));  
        }  

        .btn-secondary {  
            background-color: #f8f9fa;  
            color: #6c757d;  
            border: none;  
        }  
    </style>  
</head>  
<body>  
<div class="container">  
    <div class="profile-container">  
        <h2 class="mb-4 text-center" style="color: var(--primary-color);">  
            <i class="ri-user-settings-line me-2"></i>Edit Profil  
        </h2>  
        
        @if ($errors->any())  
            <div class="alert alert-danger">  
                <ul>  
                    @foreach ($errors->all() as $error)  
                        <li>{{ $error }}</li>  
                    @endforeach  
                </ul>  
            </div>  
        @endif  

        <form action="{{ route('client.update-profile') }}" method="POST">  
            @csrf  
            @method('PUT')  
            
            <div class="row">  
                <div class="col-md-6 mb-3">  
                    <label class="form-label"><i class="ri-user-line me-2"></i>Nama Lengkap</label>  
                    <input type="text" name="full_name" class="form-control"   
                           value="{{ old('full_name', $client->full_name) }}" required>  
                </div>  
                
                <div class="col-md-6 mb-3">  
                    <label class="form-label"><i class="ri-calendar-line me-2"></i>Tanggal Lahir</label>  
                    <input type="date" name="birth_date" class="form-control"   
                           value="{{ old('birth_date', $client->birth_date) }}" required>  
                </div>  
            </div>  

            <div class="row">  
                <div class="col-md-6 mb-3">  
                    <label class="form-label"><i class="ri-gender-line me-2"></i>Jenis Kelamin</label>  
                    <select name="gender" class="form-select" required>  
                        <option value="male" {{ old('gender', $client->gender) == 'male' ? 'selected' : '' }}>  
                            Laki-laki  
                        </option>  
                        <option value="female" {{ old('gender', $client->gender) == 'female' ? 'selected' : '' }}>  
                            Perempuan  
                        </option>  
                    </select>  
                </div>  

                <div class="col-md-6 mb-3">  
                    <label class="form-label"><i class="ri-phone-line me-2"></i>Nomor Telepon</label>  
                    <input type="text" name="phone" class="form-control"   
                           value="{{ old('phone', $client->phone) }}" required>  
                </div>  
            </div>  

            <div class="mb-3">  
                <label class="form-label"><i class="ri-map-pin-line me-2"></i>Alamat</label>  
                <textarea name="address" class="form-control" rows="3" required>{{ old('address', $client->address) }}</textarea>  
            </div>  

            <div class="d-flex justify-content-center gap-3 mt-4">  
                <a href="{{ route('client.profil') }}" class="btn btn-secondary px-4">  
                    <i class="ri-close-line me-2"></i>Batal  
                </a>  
                <button type="submit" class="btn btn-primary px-4">  
                    <i class="ri-save-line me-2"></i>Simpan Perubahan  
                </button>  
            </div>  
        </form>  
    </div>  
</div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
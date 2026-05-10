<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - FineXa</title>
    <!-- Memanggil CSS Bootstrap agar tampilan rapi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow" style="width: 400px;">
    <div class="card-body">
        <h4 class="text-center mb-4">Login Admin FineXa</h4>

        {{-- Menampilkan pesan error kalau email/password salah --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Login yang akan mengirim data ke Route /login --}}
        <form action="{{ url('/login') }}" method="POST">
            
            {{-- Stempel Keamanan Wajib --}}
            @csrf
            
            <div class="mb-3">
                <label>Email Terdaftar</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Ingat password saya
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Masuk Sistem</button>
            
            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary">Lupa Password?</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
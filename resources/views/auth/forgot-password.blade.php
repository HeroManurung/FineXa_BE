<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - FineXa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow" style="width: 400px;">
    <div class="card-body">
        <h4 class="text-center mb-3">Lupa Password?</h4>
        <p class="text-muted text-center small mb-4">Masukkan email terdaftar, kami akan kirimkan link reset password.</p>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="alert alert-success small">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tambahkan juga untuk Error (Email tidak ditemukan) --}}
        @if ($errors->any())
            <div class="alert alert-danger small">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email Terdaftar</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
            
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none small">Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuesioner FineXa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="text-center mb-4">Kuesioner Profil Risiko FineXa</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ url('/web/kuesioner') }}" method="POST">
                @csrf
                
                <!-- Pertanyaan 1 -->
                <div class="mb-3">
                    <label class="fw-bold">1. Kapan Anda berencana mencairkan dana investasi ini?</label>
                    <select name="skor_waktu" class="form-select" required>
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="1">Kurang dari 1 tahun</option>
                        <option value="2">1 sampai 5 tahun</option>
                        <option value="3">Lebih dari 5 tahun</option>
                    </select>
                </div>

                <!-- Pertanyaan 2 -->
                <div class="mb-3">
                    <label class="fw-bold">2. Jika nilai investasi turun 15% dalam sebulan, apa yang Anda lakukan?</label>
                    <select name="skor_risiko" class="form-select" required>
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="1">Panik dan menjual semuanya</option>
                        <option value="2">Cemas, tapi membiarkannya saja</option>
                        <option value="3">Tenang dan justru membeli lebih banyak</option>
                    </select>
                </div>

                <!-- Pertanyaan 3 -->
                <div class="mb-3">
                    <label class="fw-bold">3. Berapa persen dari pendapatan bulanan yang bisa disisihkan?</label>
                    <select name="skor_kapasitas" class="form-select" required>
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="1">Kurang dari 10%</option>
                        <option value="2">10% - 20%</option>
                        <option value="3">Lebih dari 20%</option>
                    </select>
                </div>

                <!-- Pertanyaan 4 -->
                <div class="mb-3">
                    <label class="fw-bold">4. Bagaimana kondisi hutang atau cicilan Anda saat ini?</label>
                    <select name="skor_hutang" class="form-select" required>
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="1">Sangat berat, sering kurang uang</option>
                        <option value="2">Ada cicilan, masih bisa bayar</option>
                        <option value="3">Tidak punya hutang / cicilan sangat ringan</option>
                    </select>
                </div>

                <!-- Pertanyaan 5 -->
                <div class="mb-3">
                    <label class="fw-bold">5. Seberapa paham Anda tentang produk investasi?</label>
                    <select name="skor_pengetahuan" class="form-select" required>
                        <option value="">-- Pilih Jawaban --</option>
                        <option value="1">Sama sekali tidak paham</option>
                        <option value="2">Cukup paham dasar-dasarnya</option>
                        <option value="3">Sangat paham dan berpengalaman</option>
                    </select>
                </div>

                <hr>

                <!-- Pilihan Tipe Investor Mandiri -->
                <div class="mb-4 bg-warning p-3 rounded bg-opacity-25">
                    <label class="fw-bold text-dark">Pilih Tipe Investor Anda (Ada 6 Profil Risiko):</label>
                    <select name="profil_risiko" class="form-select border-warning" required>
                        <option value="">-- Tentukan Profil Anda --</option>
                        <option value="Sangat Konservatif">Sangat Konservatif</option>
                        <option value="Konservatif">Konservatif</option>
                        <option value="Moderat">Moderat</option>
                        <option value="Moderat Agresif">Moderat Agresif</option>
                        <option value="Agresif">Agresif</option>
                        <option value="Sangat Agresif">Sangat Agresif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">Kirim & Hitung Analisis</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
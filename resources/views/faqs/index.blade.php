@extends('layout')

@section('content')
<div class="container mt-4 mb-5">
    <div class="mb-4">
        <h3>Frequently Asked Questions</h3>
        <p class="text-muted">Temukan jawaban untuk pertanyaan umum seputar investasi dan FineXa</p>
    </div>

    <!-- Kita kelompokkan data FAQ berdasarkan kategori -->
    @php
        $groupedFaqs = $faqs->groupBy('kategori');
    @endphp

    <!-- Looping untuk setiap Kategori -->
    @foreach($groupedFaqs as $kategori => $kumpulanFaq)
        <!-- Judul Kategori (Warna Hijau) -->
        <h6 class="text-success fw-bold mt-4 mb-3">{{ $kategori }}</h6>
        
        <!-- Bungkus Accordion untuk kategori ini -->
        <div class="accordion shadow-sm" id="accordion-{{ Str::slug($kategori) }}">
            
            <!-- Looping pertanyaan di dalam kategori tersebut -->
            @foreach($kumpulanFaq as $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-{{ $faq->id_faq }}">
                        <!-- Tombol Dropdown -->
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id_faq }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id_faq }}">
                            <span class="fw-semibold">{{ $faq->pertanyaan }}</span>
                        </button>
                    </h2>
                    
                    <!-- Isi Jawaban (Dibuat full, Str::limit dihapus) -->
                    <div id="collapse-{{ $faq->id_faq }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $faq->id_faq }}" data-bs-parent="#accordion-{{ Str::slug($kategori) }}">
                        <div class="accordion-body text-secondary lh-lg">
                            {{ $faq->jawaban }}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    @endforeach

</div>
@stop
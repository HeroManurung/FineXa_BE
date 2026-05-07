<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'kategori' => 'Tentang Platform',
                'pertanyaan' => 'Apa itu FineXa?',
                'jawaban' => 'FineXa adalah platform layanan konsultasi rekomendasi investasi mandiri yang dirancang untuk membantu investor dalam membuat keputusan investasi yang lebih cerdas dan berdasarkan data. Melalui pendekatan berbasis teknologi, FineXa menyediakan analisis mendalam terhadap berbagai instrumen investasi, mulai dari saham, obligasi, hingga reksa dana, yang disesuaikan dengan profil risiko dan tujuan keuangan setiap individu. Dengan fitur-fitur inovatifnya, FineXa menjadi mitra terpercaya bagi investor pemula maupun berpengalaman untuk mengelola portofolio investasi mereka dengan lebih efisien dan terarah menuju kemandirian finansial.'
            ],
            [
                'kategori' => 'Rekomendasi Investasi',
                'pertanyaan' => 'Bagaimana sistem rekomendasi investasi FineXa bekerja?',
                'jawaban' => 'Sistem rekomendasi investasi FineXa beroperasi dengan menggunakan algoritma canggih yang dirancang khusus untuk memadukan berbagai data pasar keuangan terkini, analisis fundamental perusahaan, serta tren ekonomi makro secara real-time. Melalui pemrosesan data yang mendalam, sistem ini mampu menyaring ribuan instrumen investasi untuk memberikan saran yang paling relevan dengan profil risiko dan tujuan keuangan pengguna. Selain itu, sistem FineXa juga bersifat dinamis, secara berkala memperbarui rekomendasinya seiring dengan perubahan kondisi pasar dan perkembangan teknologi keuangan terkini.'
            ],
            [
                'kategori' => 'Edukasi Investasi',
                'pertanyaan' => 'Apa saja yang dipelajari di Edukasi Investasi FineXa?',
                'jawaban' => 'Belajar investasi kini lebih mudah melalui Edukasi Investasi FineXa. Dapatkan akses ke berbagai materi pembelajaran yang informatif mulai dari konsep dasar investasi hingga strategi pengelolaan portofolio yang lebih canggih. Melalui artikel, video edukatif, dan webinar interaktif, FineXa berkomitmen untuk meningkatkan literasi keuangan pengguna agar dapat mengambil keputusan investasi yang lebih bijak dan terinformasi.'
            ],
            [
                'kategori' => 'Profil Risiko',
                'pertanyaan' => 'Apa itu Profil Risiko?',
                'jawaban' => 'Profil risiko adalah gambaran kemampuan dan kesediaan seseorang dalam menghadapi risiko fluktuasi nilai investasi. Setiap orang memiliki toleransi risiko yang berbeda-beda, mulai dari yang sangat konservatif hingga sangat agresif. Dengan memahami profil risiko kamu, FineXa dapat memberikan rekomendasi produk investasi yang paling sesuai agar perjalanan investasimu terasa lebih nyaman dan terarah sesuai dengan tujuan keuangan jangka panjang.'
            ],
            [
                'kategori' => 'Keamanan Data',
                'pertanyaan' => 'Bagaimana perlindungan data pengguna di FineXa?',
                'jawaban' => 'Keamanan data pengguna adalah prioritas utama kami di FineXa. Kami mengimplementasikan standar keamanan teknologi informasi terkini guna melindungi informasi pribadi dan finansial kamu dari akses yang tidak sah. Melalui penggunaan enkripsi tingkat tinggi dan sistem pemantauan yang ketat, kami berupaya memastikan seluruh data pengguna tersimpan dengan aman dan tetap terjaga kerahasiaannya sesuai dengan regulasi perlindungan data yang berlaku.'
            ],
            [
                'kategori' => 'Risiko Investasi',
                'pertanyaan' => 'Memahami Risiko Investasi',
                'jawaban' => 'Berinvestasi selalu memiliki risiko, namun dengan pemahaman yang tepat, risiko tersebut dapat dikelola dengan bijak. Setiap instrumen investasi memiliki karakteristik risiko yang berbeda-beda, seperti risiko pasar, risiko likuiditas, hingga risiko kredit. FineXa membantu pengguna untuk mengenali berbagai jenis risiko ini melalui analisis data yang transparan sehingga kamu dapat mengambil langkah investasi yang lebih terencana dan sesuai dengan batas toleransi risikomu.'
            ]
        ];

            foreach ($faqs as $faq) {
                Faq::create($faq);
        }
    }
}
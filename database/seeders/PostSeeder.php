<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Starter articles (Indonesian). firstOrCreate on the slug, so running it again never overwrites edits made in admin.
 * Edit, replace or delete them in admin (Blog posts).
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->posts() as $post) {
            Post::firstOrCreate(['slug' => $post['slug']], $post + ['is_published' => true]);
        }
    }

    private function posts(): array
    {
        return [
            [
                'slug' => 'chatbot-ai-yang-berguna-bukan-yang-terdengar-pintar',
                'title_id' => 'Chatbot AI yang Berguna, Bukan yang Sekadar Terdengar Pintar',
                'excerpt_id' => 'Menghubungkan model AI ke aplikasi itu mudah. Membuat chatbot yang benar-benar menyelesaikan masalah pengguna jauh lebih sulit, dan di situlah pekerjaannya.',
                'published_at' => Carbon::parse('2026-10-06 08:00:00'),
                'body_id' => <<<'MD'
Memanggil sebuah model AI dari aplikasi sekarang bisa dilakukan dalam beberapa baris kode. Hasilnya langsung terlihat meyakinkan: jawabannya lancar, rapi, dan terdengar pintar. Justru karena itu, bagian tersulit dari membangun chatbot sering kali bukan teknisnya, melainkan memutuskan **apa yang sebenarnya boleh dan perlu dijawab**.

#### Mulai dari pertanyaan pengguna, bukan dari modelnya

Sebelum memilih model, tulis dulu lima belas pertanyaan yang paling sering diajukan orang kepada tim Anda. Dari situ terlihat bahwa sebagian besar pertanyaan itu sempit dan berulang. Chatbot yang baik tidak perlu tahu segalanya. Ia perlu menjawab pertanyaan yang sempit itu dengan benar, setiap kali.

#### Beri batas yang jelas

Model bahasa cenderung menjawab walaupun tidak tahu. Karena itu saya memperlakukan tiga hal sebagai bagian dari desain, bukan tambahan:

- **Sumber jawaban yang jelas.** Berikan dokumen atau data yang boleh dipakai, dan minta model menjawab hanya dari sana.
- **Jawaban "saya tidak tahu" yang sopan.** Lebih baik mengarahkan pengguna ke manusia daripada memberi jawaban yang salah dengan nada yakin.
- **Topik yang di luar jangkauan.** Tentukan sejak awal hal-hal yang tidak boleh dijawab, misalnya keputusan hukum atau medis.

#### Ukur dengan percakapan nyata

Contoh yang bagus di layar demo tidak membuktikan apa pun. Kumpulkan percakapan nyata, tandai mana yang berhasil dan mana yang gagal, lalu perbaiki instruksi dan datanya berdasarkan kegagalan itu. Pola yang sama terus berulang: pertanyaan ambigu, istilah internal yang tidak dikenal model, dan data yang sudah usang.

#### Rancang jalan keluarnya

Chatbot yang menyelesaikan 70 persen pertanyaan dengan baik dan mengoper sisanya ke manusia dengan konteks yang lengkap, lebih berguna daripada chatbot yang berusaha menjawab semuanya. Pengguna biasanya memaafkan chatbot yang jujur tentang batasnya. Mereka jarang memaafkan yang salah dengan penuh percaya diri.

Ringkasnya: model AI adalah bahan baku. Produknya adalah batas, data, dan cara chatbot itu gagal dengan baik.
MD,
            ],
            [
                'slug' => 'mengotomatiskan-alur-kerja-dengan-n8n',
                'title_id' => 'Mengotomatiskan Alur Kerja dengan n8n: Mulai dari Satu Langkah yang Membosankan',
                'excerpt_id' => 'Otomasi yang bertahan lama biasanya dimulai dari satu pekerjaan berulang yang paling membosankan, bukan dari rencana besar.',
                'published_at' => Carbon::parse('2026-09-29 08:00:00'),
                'body_id' => <<<'MD'
Setiap tim punya pekerjaan kecil yang diulang-ulang: menyalin data dari satu tempat ke tempat lain, mengirim pemberitahuan, merapikan format, memeriksa apakah sesuatu sudah selesai. Pekerjaan seperti itu tidak sulit, tapi menguras perhatian. Di situlah alat otomasi seperti **n8n** terasa paling berguna.

#### Pilih satu pekerjaan, bukan satu sistem

Kesalahan yang paling sering saya lihat adalah memulai dari gambaran besar: "kita otomasi seluruh proses". Alur kerja yang besar sulit diuji dan sulit dipercaya. Pilih satu pekerjaan yang jelas awal dan akhirnya, lakukan secara manual sekali sambil mencatat langkahnya, lalu pindahkan langkah itu ke sebuah workflow.

#### Pikirkan pemicu dan kegagalan lebih dulu

Alur kerja yang berjalan sendiri harus bisa memberi tahu ketika ia gagal. Tiga pertanyaan yang saya ajukan sebelum menyalakan workflow apa pun:

1. Apa yang memicunya, dan apakah pemicu itu bisa terkirim dua kali?
2. Apa yang terjadi kalau layanan di tengah jalan sedang tidak tersedia?
3. Siapa yang diberi tahu kalau sebuah langkah gagal?

Tanpa jawaban untuk ketiganya, otomasi hanya memindahkan masalah dari tangan manusia ke tempat yang tidak ada yang memperhatikan.

#### Tambahkan AI di tempat yang tepat

Model AI cocok untuk langkah yang butuh memahami teks: merangkum, mengklasifikasi, menyusun draf balasan. Ia kurang cocok untuk langkah yang butuh kepastian mutlak, seperti menghitung atau mengubah data penting. Pola yang berjalan baik adalah AI menyiapkan, manusia atau aturan yang jelas memutuskan.

#### Dokumentasikan seperlunya

Satu kalimat di setiap workflow tentang tujuannya, siapa pemiliknya, dan apa yang harus dilakukan saat ia berhenti, sudah menyelamatkan banyak waktu beberapa bulan kemudian, ketika Anda sendiri sudah lupa cara kerjanya.
MD,
            ],
            [
                'slug' => 'dari-sitemap-ke-artikel-membangun-pipeline-konten',
                'title_id' => 'Dari Sitemap ke Artikel: Membangun Pipeline Konten yang Bertanggung Jawab',
                'excerpt_id' => 'Sitemap membuat penemuan artikel baru jadi otomatis. Yang menentukan kualitas hasilnya adalah etika pengambilan data dan cara menulis ulangnya.',
                'published_at' => Carbon::parse('2026-09-22 08:00:00'),
                'body_id' => <<<'MD'
Salah satu proyek yang paling banyak mengajari saya adalah membangun pipeline yang menemukan artikel baru lewat **sitemap**, mengambil isinya, lalu menulis ulang dalam bahasa Indonesia dengan bantuan model AI. Sumbernya publikasi seperti Search Engine Journal dan Search Engine Land. Secara teknis alurnya sederhana. Yang membuatnya menantang ada di tempat lain.

#### Sitemap adalah pintu masuk yang sopan

Sitemap memberi daftar halaman beserta tanggal pembaruannya. Dengan membacanya, pipeline tidak perlu menjelajahi seluruh situs. Ia cukup memeriksa apa yang baru sejak kunjungan terakhir. Ini lebih hemat dan lebih ramah bagi server sumber.

#### Alurnya

1. Baca sitemap dan ambil alamat artikel yang belum pernah diproses.
2. Ambil halaman, lalu ekstrak bagian isi saja dan buang navigasi, iklan, dan sisanya.
3. Kirim isi ke model AI dengan instruksi menulis ulang dalam bahasa Indonesia, dengan struktur dan gaya yang jelas.
4. Simpan hasilnya sebagai draf, bukan langsung terbit, lalu jadwalkan penerbitannya.

#### Bagian yang menentukan kualitas

- **Hormati aturan situs sumber.** Baca `robots.txt`, beri jeda antar permintaan, dan jangan membebani server mereka.
- **Jangan menyalin.** Menulis ulang berarti menyusun kalimat sendiri dari fakta yang sama. Sebutkan sumbernya dan beri tautan ke artikel aslinya.
- **Periksa fakta dan angka.** Model bisa mengubah angka atau menambahkan detail yang tidak ada di sumber. Untuk topik yang sensitif, tinjauan manusia sebelum terbit bukan pilihan.
- **Catat apa yang sudah diproses**, supaya artikel yang sama tidak diolah dua kali.

#### Pelajaran terbesarnya

Otomasi membuat produksi konten murah. Justru karena murah, standar kualitasnya harus dijaga di alur kerjanya sendiri: sumber yang jelas, atribusi, dan tahap tinjauan. Tanpa itu, yang dihasilkan hanyalah lebih banyak teks, bukan lebih banyak informasi yang bisa dipercaya.
MD,
            ],
            [
                'slug' => 'belajar-machine-learning-sedikit-sedikit-dengan-kaggle',
                'title_id' => 'Belajar Machine Learning Sedikit-Sedikit dengan Kaggle',
                'excerpt_id' => 'Tidak perlu menunggu waktu luang yang panjang. Satu dataset kecil, satu pertanyaan, dan satu notebook sudah cukup untuk mulai memahami cara kerja model.',
                'published_at' => Carbon::parse('2026-09-15 08:00:00'),
                'body_id' => <<<'MD'
Sebagai software engineer yang sehari-hari memakai model AI lewat API, saya sadar ada jarak antara memakai model dan memahami bagaimana model itu dibentuk. Cara saya mengecilkan jarak itu: belajar machine learning **sedikit-sedikit**, memakai dataset di Kaggle.

#### Mulai dari pertanyaan kecil

Dataset besar membuat kewalahan. Saya lebih suka dataset kecil dengan pertanyaan yang jelas, misalnya "bisakah kita memperkirakan nilai ini dari kolom-kolom lainnya?". Pertanyaan yang sempit membuat setiap langkah punya alasan.

#### Urutan yang saya ikuti

1. **Kenali datanya.** Lihat bentuknya, nilai yang hilang, dan sebarannya, sebelum menyentuh model apa pun.
2. **Bersihkan secukupnya.** Sebagian besar waktu habis di sini, dan itu normal.
3. **Mulai dengan model paling sederhana.** Hasilnya menjadi patokan. Model yang lebih rumit baru berarti kalau ia mengalahkan patokan itu.
4. **Pisahkan data latih dan data uji** sebelum mengukur apa pun, supaya hasilnya tidak menipu diri sendiri.
5. **Tulis apa yang dipelajari.** Satu paragraf di akhir notebook tentang apa yang berhasil dan tidak berhasil.

#### Apa yang berubah dalam pekerjaan saya

Belajar dari sisi data membuat saya lebih tenang menghadapi model AI di produk. Saya lebih cepat menyadari ketika sebuah hasil terlalu bagus untuk dipercaya, dan lebih paham mengapa kualitas data lebih menentukan daripada pilihan model.

Saya belum merasa ahli, dan itu tidak masalah. Tujuannya bukan gelar, tapi kebiasaan: sedikit demi sedikit, tapi rutin.
MD,
            ],
        ];
    }
}

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
                'slug' => 'seo-aeo-geo-membuat-situs-terbaca-mesin-pencari-dan-ai',
                'title' => 'SEO, AEO and GEO: Making a Site Readable to Search Engines and AI Answer Engines',
                'title_id' => 'SEO, AEO, dan GEO: Membuat Situs Terbaca oleh Mesin Pencari dan Mesin Jawaban AI',
                'excerpt' => 'People now get answers from search results and from AI assistants. A short, practical look at what I set up so a site can be found and understood by both, and what no setup can promise.',
                'excerpt_id' => 'Orang kini mendapat jawaban dari hasil pencarian dan dari asisten AI. Catatan singkat tentang apa yang saya siapkan agar sebuah situs bisa ditemukan dan dipahami keduanya, dan apa yang tidak bisa dijanjikan oleh pengaturan apa pun.',
                'published_at' => Carbon::parse('2026-10-15 08:00:00'),
                'body' => <<<'MD'
Search used to mean ten blue links. Today a question can be answered by a search engine, by a summary above the results, or by an AI assistant that never shows a list at all. A site that wants to be found has to be readable to all three. The three abbreviations people use for this are simple once you strip the jargon.

- **SEO** (search engine optimisation): help search engines find, understand and rank your pages.
- **AEO** (answer engine optimisation): make your content easy to quote as a direct answer.
- **GEO** (generative engine optimisation): make your content easy for AI systems to read, trust and attribute.

I rebuilt my own portfolio with all three in mind. Here is what actually went in, and what I would tell a friend doing the same.

#### Start with content a person can understand

No technical setting rescues a page that says nothing clear. Each page should answer one question in plain words: who this is, what the project does, what the article covers. Short headings that read like the questions people ask help both humans and machines. Everything below only makes good content easier to find; it does not replace it.

#### Tell machines what the page is

Structured data (JSON-LD) is a small block of text that says, in a format every engine understands, "this page is a person", "this is an article", "this is a list of questions and answers". On this site the home page describes me as a person with a role and links to my profiles. Articles are marked as articles, project pages as creative works, and the About page carries a short FAQ. It costs a few lines per page and removes guesswork for the crawler.

#### Make the basics boring and correct

- **One address per page.** A canonical link says which URL is the real one, so the same page is never counted twice.
- **Two languages, declared.** With an Indonesian and an English version, `hreflang` tells search engines which version belongs to which reader, so people see their own language.
- **A real sitemap.** It lists every page and every language version, and updates itself when I publish something new.
- **A clean robots.txt.** It says what may be crawled and points to the sitemap. Admin pages stay out.
- **Speed and mobile.** A slow or broken phone layout hurts people first and rankings second. Image sizes, self-hosted fonts and lazy loading did more for this than any clever trick.

#### Speak to AI systems directly

Two plain text files are becoming common for this. `llms.txt` is a short, readable summary of the site for language models, with links to the most useful pages. `ai.txt` states how AI crawlers may use the content, for example with attribution. I added both, plus a longer version of the summary, and listed the major AI crawlers in robots.txt so the rules are explicit.

An honest note: these files are conventions, not guarantees. No major platform has promised to rank or quote a site because of them. I treat them as cheap, harmless and clear, not as a switch.

#### What no setup can promise

None of this guarantees a position in search or a mention in an AI answer. Indexing can take days or weeks, rankings depend on competition and on whether other sites link to you, and AI systems decide for themselves what to quote. What you can control is that nothing technical stands in the way: pages load fast, say what they are, exist in the right language and can be crawled. After that it is about being worth quoting.

#### A small checklist

1. Every page answers one clear question.
2. Structured data on the home, article and project pages.
3. Canonical links and `hreflang` if you have more than one language.
4. Sitemap and robots.txt that are correct and current.
5. Fast on a phone, with sensible image sizes.
6. Verified in Search Console, sitemap submitted, key pages requested for indexing.
7. Optionally `llms.txt` and `ai.txt`, without expecting miracles.

If you do only the first and the last two, you are already ahead of most sites.
MD,
                'body_id' => <<<'MD'
Dulu pencarian berarti sepuluh tautan biru. Sekarang satu pertanyaan bisa dijawab oleh mesin pencari, oleh ringkasan di atas hasil, atau oleh asisten AI yang sama sekali tidak menampilkan daftar. Situs yang ingin ditemukan harus bisa dibaca ketiganya. Tiga singkatan yang dipakai untuk ini sebenarnya sederhana kalau istilahnya dibuang.

- **SEO** (search engine optimisation): membantu mesin pencari menemukan, memahami, dan memeringkat halaman Anda.
- **AEO** (answer engine optimisation): membuat konten mudah dikutip sebagai jawaban langsung.
- **GEO** (generative engine optimisation): membuat konten mudah dibaca, dipercaya, dan disebutkan sumbernya oleh sistem AI.

Saya membangun ulang portofolio saya dengan ketiganya dalam pikiran. Berikut yang benar-benar saya pasang, dan yang akan saya sarankan kepada teman yang melakukan hal serupa.

#### Mulai dari konten yang bisa dipahami manusia

Tidak ada pengaturan teknis yang menyelamatkan halaman yang tidak jelas isinya. Setiap halaman sebaiknya menjawab satu pertanyaan dengan kata-kata sederhana: siapa ini, apa yang dilakukan proyek ini, apa isi artikel ini. Judul bagian yang pendek dan terbaca seperti pertanyaan yang diajukan orang membantu manusia maupun mesin. Semua yang di bawah ini hanya membuat konten yang baik lebih mudah ditemukan, bukan menggantikannya.

#### Beri tahu mesin halaman itu apa

Data terstruktur (JSON-LD) adalah blok teks kecil yang menyatakan, dalam format yang dipahami semua mesin, "halaman ini adalah seseorang", "ini artikel", "ini daftar pertanyaan dan jawaban". Di situs ini, beranda menggambarkan saya sebagai seseorang dengan peran dan tautan ke profil saya. Artikel ditandai sebagai artikel, halaman proyek sebagai karya kreatif, dan halaman Tentang memuat FAQ singkat. Biayanya beberapa baris per halaman, dan menghilangkan tebak-tebakan bagi crawler.

#### Buat dasar-dasarnya membosankan dan benar

- **Satu alamat untuk satu halaman.** Tautan kanonis menyatakan URL mana yang asli, sehingga halaman yang sama tidak dihitung dua kali.
- **Dua bahasa, dinyatakan.** Dengan versi Indonesia dan Inggris, `hreflang` memberi tahu mesin pencari versi mana untuk pembaca mana, sehingga orang melihat bahasanya sendiri.
- **Sitemap yang sungguhan.** Berisi semua halaman dan semua versi bahasa, dan memperbarui dirinya sendiri saat saya menerbitkan sesuatu.
- **robots.txt yang bersih.** Menyatakan apa yang boleh dirayapi dan menunjuk ke sitemap. Halaman admin tetap di luar.
- **Kecepatan dan tampilan ponsel.** Halaman lambat atau tata letak ponsel yang rusak merugikan orang lebih dulu, baru peringkat. Ukuran gambar, font yang dihosting sendiri, dan pemuatan malas membantu lebih banyak daripada trik apa pun.

#### Berbicara langsung kepada sistem AI

Dua berkas teks biasa mulai umum untuk ini. `llms.txt` adalah ringkasan singkat yang mudah dibaca tentang situs untuk model bahasa, dengan tautan ke halaman yang paling berguna. `ai.txt` menyatakan bagaimana crawler AI boleh memakai konten, misalnya dengan menyebutkan sumber. Saya menambahkan keduanya, ditambah versi ringkasan yang lebih panjang, dan mencantumkan crawler AI utama di robots.txt supaya aturannya eksplisit.

Catatan jujur: berkas-berkas ini adalah konvensi, bukan jaminan. Tidak ada platform besar yang berjanji memeringkat atau mengutip situs karena berkas itu. Saya memperlakukannya sebagai hal yang murah, tidak berbahaya, dan jelas, bukan sebagai tombol ajaib.

#### Yang tidak bisa dijanjikan oleh pengaturan apa pun

Semua ini tidak menjamin posisi di pencarian atau sebutan dalam jawaban AI. Pengindeksan bisa memakan waktu berhari-hari sampai berminggu-minggu, peringkat bergantung pada persaingan dan pada apakah situs lain menautkan Anda, dan sistem AI menentukan sendiri apa yang dikutip. Yang bisa Anda kendalikan adalah memastikan tidak ada hambatan teknis: halaman cepat dimuat, jelas isinya, ada dalam bahasa yang tepat, dan bisa dirayapi. Setelah itu, soal apakah isinya layak dikutip.

#### Daftar periksa singkat

1. Setiap halaman menjawab satu pertanyaan yang jelas.
2. Data terstruktur di beranda, artikel, dan halaman proyek.
3. Tautan kanonis dan `hreflang` jika lebih dari satu bahasa.
4. Sitemap dan robots.txt yang benar dan terkini.
5. Cepat di ponsel, dengan ukuran gambar yang wajar.
6. Terverifikasi di Search Console, sitemap terkirim, halaman penting diminta untuk diindeks.
7. Opsional `llms.txt` dan `ai.txt`, tanpa mengharapkan keajaiban.

Kalau Anda hanya melakukan yang pertama dan dua terakhir, Anda sudah lebih maju daripada kebanyakan situs.
MD,
            ],
            [
                'slug' => 'menerima-pembayaran-midtrans-di-laravel-yang-perlu-diperhatikan',
                'title' => 'Accepting Midtrans Payments in Laravel: What Is Worth Getting Right',
                'title_id' => 'Menerima Pembayaran Midtrans di Laravel: Hal yang Perlu Dibenahi Sejak Awal',
                'excerpt' => 'Showing a payment page is the easy part. Notes from building several Laravel shops and platforms on Midtrans: confirm payments on the server, verify the signature and expect the same notification twice.',
                'excerpt_id' => 'Menampilkan halaman pembayaran itu bagian yang mudah. Catatan dari beberapa toko dan platform Laravel yang saya bangun dengan Midtrans: konfirmasi pembayaran di server, verifikasi signature, dan siap menerima notifikasi yang sama dua kali.',
                'published_at' => Carbon::parse('2026-10-15 09:00:00'),
                'body' => <<<'MD'
I have built several products on Midtrans with Laravel: an e-book store, a learning platform, an event-ticketing site, an online bakery and a multi-role beauty store. The checkout page always looks like the hard part. It is not. The parts that decide whether the money and the orders agree with each other are quieter.

#### The browser is not the source of truth

After paying, the customer is sent back to your site. It is tempting to mark the order as paid right there. Do not. A customer can close the tab, lose signal or hit back before the redirect happens, and a redirect can be forged by anyone. The payment status should come from Midtrans telling your server directly, through the notification (webhook) endpoint.

#### Verify the notification

Anyone can send a request to your notification URL. Midtrans includes a `signature_key` that is a SHA-512 hash of the order id, status code, gross amount and your server key. Recompute it and compare before trusting anything in the request. If it does not match, ignore it. As an extra check, you can ask Midtrans for the transaction status with the order id and compare.

#### Expect the same notification more than once

Notifications can arrive twice, late or out of order. Your handler should be idempotent: running it again must not ship a second parcel, add stock twice or send two emails. A simple rule that works is to only move an order forward (pending to paid, never paid back to pending) and to record that the side effects already ran.

#### Make order ids and amounts boring

Use an order id that is unique per attempt and tied to your own order record. Keep the amount in whole rupiah and calculate it on the server, never from a hidden form field. If a customer retries payment on the same order, decide in advance whether that creates a new Midtrans order id.

#### Test the unhappy paths

Sandbox makes the happy path easy. Spend the time on the others: expired payments, cancelled payments, a closed tab, a notification that arrives before the customer is redirected, and a webhook that is down for a minute. Those are the cases a real shop meets in its first week.

#### Keep keys and environments apart

Server keys belong in the environment file, never in the repository or the front end. Keep sandbox and production keys clearly separated and double check which one a deployment is using before launch day.

None of this is exotic. It is a short checklist, and it is the difference between a checkout that looks finished and one that quietly stays correct.
MD,
                'body_id' => <<<'MD'
Saya sudah membangun beberapa produk dengan Midtrans di Laravel: toko e-book, platform belajar, situs tiket event, toko roti online, dan toko kecantikan multi-peran. Halaman checkout selalu terlihat seperti bagian tersulit. Padahal bukan. Bagian yang menentukan apakah uang dan pesanan saling cocok justru lebih sunyi.

#### Browser bukan sumber kebenaran

Setelah membayar, pelanggan dikembalikan ke situs Anda. Godaan terbesarnya menandai pesanan sebagai lunas di situ. Jangan. Pelanggan bisa menutup tab, kehilangan sinyal, atau menekan kembali sebelum redirect terjadi, dan redirect bisa dipalsukan siapa saja. Status pembayaran harus datang dari Midtrans yang memberi tahu server Anda langsung, lewat endpoint notifikasi (webhook).

#### Verifikasi notifikasinya

Siapa pun bisa mengirim permintaan ke URL notifikasi Anda. Midtrans menyertakan `signature_key`, yaitu hash SHA-512 dari order id, status code, gross amount, dan server key Anda. Hitung ulang dan bandingkan sebelum memercayai apa pun di dalam permintaan itu. Kalau tidak cocok, abaikan. Sebagai pemeriksaan tambahan, Anda bisa menanyakan status transaksi ke Midtrans dengan order id dan membandingkannya.

#### Siap menerima notifikasi yang sama lebih dari sekali

Notifikasi bisa datang dua kali, terlambat, atau tidak berurutan. Handler Anda harus idempoten: dijalankan lagi tidak boleh mengirim paket kedua, menambah stok dua kali, atau mengirim dua email. Aturan sederhana yang berfungsi: hanya majukan pesanan ke status berikutnya (pending ke lunas, tidak pernah lunas kembali ke pending) dan catat bahwa efek sampingnya sudah dijalankan.

#### Buat order id dan nominal yang membosankan

Pakai order id yang unik per percobaan dan terhubung ke catatan pesanan Anda sendiri. Simpan nominal dalam rupiah utuh dan hitung di server, jangan pernah dari kolom form tersembunyi. Kalau pelanggan mencoba bayar ulang pada pesanan yang sama, putuskan lebih dulu apakah itu membuat order id Midtrans baru.

#### Uji jalur yang tidak menyenangkan

Sandbox membuat jalur yang lancar mudah. Habiskan waktu untuk jalur lainnya: pembayaran kedaluwarsa, pembayaran dibatalkan, tab ditutup, notifikasi yang tiba sebelum pelanggan dialihkan, dan webhook yang mati semenit. Itulah kasus yang ditemui toko sungguhan pada minggu pertamanya.

#### Pisahkan kunci dan lingkungan

Server key ada di file environment, bukan di repositori atau di front end. Pisahkan kunci sandbox dan produksi dengan jelas, dan periksa kembali mana yang dipakai deployment sebelum hari peluncuran.

Tidak ada yang eksotis di sini. Ini daftar periksa singkat, dan itulah beda antara checkout yang tampak selesai dan yang diam-diam tetap benar.
MD,
            ],
            [
                'slug' => 'pelajaran-membangun-aplikasi-ai-untuk-industri-kecantikan',
                'title' => 'Lessons from Building AI Tools for the Beauty Industry',
                'title_id' => 'Pelajaran dari Membangun Alat AI untuk Industri Kecantikan',
                'excerpt' => 'An adaptive wellness analyzer, a product concept simulator and a team of AI assistants for experts. What changes when AI meets a domain with real consequences, and why a good conversation beats a long form.',
                'excerpt_id' => 'Analyzer wellness adaptif, simulator konsep produk, dan tim asisten AI untuk para ahli. Apa yang berubah ketika AI bertemu bidang dengan konsekuensi nyata, dan mengapa percakapan yang baik mengalahkan formulir panjang.',
                'published_at' => Carbon::parse('2026-10-15 10:00:00'),
                'body' => <<<'MD'
At Lunaray Beauty Factory in Bandung I work on software, and increasingly on AI tools for a cosmetics business. Two of them are the Cantik.AI Wellness Analyzer and an AI Product Concept Simulator, and we introduced Cantik.ai at Cosmobeauty. Here is what I took away from building them.

#### A conversation beats a long form

A wellness analysis normally starts with a long questionnaire. People abandon those. The analyzer instead asks a few questions and decides what to ask next based on the previous answers, wired together with n8n workflows. The visitor feels they are talking, not filling in boxes, and the result still has enough information behind it. The lesson: make the interface as short as the situation allows, and let the logic do the branching.

#### The domain sets the rules, not the model

Skin and wellness are areas where a confident wrong answer is worse than no answer. That changes how the tool is written. It should stay inside what the product knows, say plainly when something is outside its scope, and avoid claiming medical results. The expert in the room, a formulator or a brand specialist, sets those boundaries. My job is to turn them into prompts, data and checks.

#### AI that supports experts, not AI that replaces them

The concept simulator takes a rough product idea and walks it through guided steps toward a structured concept with a price simulation and a report. It does not decide what to make. It saves the first hours of structuring so the specialists can spend their time on judgement. The most useful AI tools I have built are the ones that make a skilled person faster.

#### Show it to real people early

Seeing visitors use the analyzer at a trade show taught me more than a week of testing at my desk. People type unexpected things, switch language halfway and put the phone down mid-conversation. A tool that survives that is a product.

#### What I would repeat

1. Start from the user's shortest path to a useful answer.
2. Let the domain expert define what the tool must never say.
3. Use automation (n8n) for the plumbing and keep the prompts small and testable.
4. Put it in front of real users as soon as it is safe to do so.
MD,
                'body_id' => <<<'MD'
Di Lunaray Beauty Factory, Bandung, saya mengerjakan perangkat lunak, dan semakin banyak alat AI untuk bisnis kosmetik. Dua di antaranya adalah Cantik.AI Wellness Analyzer dan AI Product Concept Simulator, dan Cantik.ai kami perkenalkan di Cosmobeauty. Inilah yang saya bawa pulang dari membangunnya.

#### Percakapan mengalahkan formulir panjang

Analisis wellness biasanya diawali kuesioner panjang. Orang meninggalkannya. Analyzer ini justru mengajukan beberapa pertanyaan lalu menentukan pertanyaan berikutnya dari jawaban sebelumnya, dirangkai dengan workflow n8n. Pengunjung merasa sedang berbicara, bukan mengisi kotak, dan hasilnya tetap punya cukup informasi. Pelajarannya: buat antarmuka sependek yang diizinkan situasinya, dan biarkan logika yang bercabang.

#### Bidangnya yang menentukan aturan, bukan modelnya

Kulit dan wellness adalah area di mana jawaban salah yang percaya diri lebih buruk daripada tidak menjawab. Itu mengubah cara alat ini ditulis. Ia harus tetap di dalam yang diketahui produk, berkata terus terang saat sesuatu di luar cakupannya, dan tidak mengklaim hasil medis. Ahli di ruangan itu, formulator atau spesialis brand, yang menetapkan batasnya. Tugas saya menerjemahkannya menjadi prompt, data, dan pemeriksaan.

#### AI yang mendukung ahli, bukan menggantikannya

Simulator konsep mengambil ide produk yang kasar dan membawanya lewat langkah terarah menuju konsep terstruktur dengan simulasi harga dan laporan. Ia tidak memutuskan apa yang dibuat. Ia menghemat jam-jam pertama penyusunan sehingga para spesialis bisa memakai waktunya untuk pertimbangan. Alat AI paling berguna yang pernah saya bangun adalah yang membuat orang terampil menjadi lebih cepat.

#### Perlihatkan ke orang sungguhan sejak dini

Melihat pengunjung memakai analyzer di pameran mengajarkan saya lebih banyak daripada seminggu menguji di meja. Orang mengetik hal tak terduga, berganti bahasa di tengah jalan, dan meletakkan ponsel di tengah percakapan. Alat yang bertahan menghadapi itu adalah produk.

#### Yang akan saya ulangi

1. Mulai dari jalur terpendek pengguna menuju jawaban yang berguna.
2. Biarkan ahli bidang menentukan apa yang tidak boleh pernah dikatakan alat itu.
3. Pakai otomasi (n8n) untuk pipanya dan jaga prompt tetap kecil dan bisa diuji.
4. Hadapkan ke pengguna nyata secepat aman dilakukan.
MD,
            ],
            [
                'slug' => 'membuat-situs-dwibahasa-dengan-laravel',
                'title' => 'Building a Bilingual Website with Laravel: Lessons from This Portfolio',
                'title_id' => 'Membuat Situs Dwibahasa dengan Laravel: Pelajaran dari Portofolio Ini',
                'excerpt' => 'Language in the URL, a column per language in the database, separate content per language and hreflang for search engines. How this portfolio serves Indonesian and English without mixing them.',
                'excerpt_id' => 'Bahasa di URL, satu kolom per bahasa di database, konten terpisah per bahasa, dan hreflang untuk mesin pencari. Cara portofolio ini melayani Indonesia dan Inggris tanpa mencampurkannya.',
                'published_at' => Carbon::parse('2026-10-15 11:00:00'),
                'body' => <<<'MD'
This portfolio is available in Indonesian and English, and the two are meant to stay separate: an English page should not contain Indonesian text, and the other way round. Getting there in Laravel took a handful of decisions that I would make the same way again.

#### Put the language in the URL

Every public page lives under `/id/...` or `/en/...`. A visitor, a link and a search engine can all tell which language a page is in just by reading the address. The root URL simply redirects to the right one using a saved choice first, then the browser's language, then Indonesian as the default. A small middleware sets the application locale from the URL and makes the language part of every generated link, so the code never has to pass it around by hand.

#### One column per language

For content stored in the database, such as projects, certificates, events and articles, each translatable field has an English base column and an `_id` column. A small trait returns the version for the current language and tells you whether a translation exists. That keeps the admin form simple: two fields side by side, no separate translation tables.

#### Do not show what you cannot translate

The easy mistake is falling back to the other language when a translation is missing. That is how Indonesian text ends up on an English page. Here, lists and pages only show content that exists in the page language, and an article that exists in one language redirects from the other language's address instead of showing a mix.

#### Tell search engines about the pair

With two versions of a page, search engines need to know they belong together. Each page declares its canonical address and an `hreflang` link to both versions, and the sitemap lists every version with its alternates. That is how an Indonesian searcher is shown the Indonesian page and an English one the English page.

#### Translate the small things too

Page titles, meta descriptions, form messages, dates and even the names of certificates need a version per language. They are easy to forget and obvious to a reader.

#### What I would tell someone starting out

1. Decide the URL structure first and keep it consistent.
2. Keep translations next to the content, not in a separate system.
3. Prefer showing less in one language over showing a mix.
4. Add `hreflang` and canonical links from day one.
MD,
                'body_id' => <<<'MD'
Portofolio ini tersedia dalam bahasa Indonesia dan Inggris, dan keduanya sengaja dipisah: halaman Inggris tidak boleh berisi teks Indonesia, begitu pula sebaliknya. Untuk mencapainya di Laravel, ada beberapa keputusan yang akan saya ambil lagi dengan cara yang sama.

#### Taruh bahasa di URL

Setiap halaman publik berada di bawah `/id/...` atau `/en/...`. Pengunjung, tautan, dan mesin pencari bisa tahu bahasa halaman hanya dari membaca alamatnya. URL akar cukup mengalihkan ke yang tepat dengan memakai pilihan yang tersimpan lebih dulu, lalu bahasa browser, lalu Indonesia sebagai bawaan. Sebuah middleware kecil menetapkan locale aplikasi dari URL dan menjadikan bahasa bagian dari setiap tautan yang dihasilkan, sehingga kode tidak perlu meneruskannya secara manual.

#### Satu kolom per bahasa

Untuk konten di database, seperti proyek, sertifikat, event, dan artikel, setiap kolom yang bisa diterjemahkan punya kolom dasar bahasa Inggris dan kolom `_id`. Sebuah trait kecil mengembalikan versi untuk bahasa saat ini dan memberi tahu apakah terjemahannya ada. Itu menjaga formulir admin tetap sederhana: dua kolom berdampingan, tanpa tabel terjemahan terpisah.

#### Jangan tampilkan yang tidak bisa diterjemahkan

Kesalahan yang mudah adalah beralih ke bahasa lain saat terjemahan tidak ada. Begitulah teks Indonesia berakhir di halaman Inggris. Di sini, daftar dan halaman hanya menampilkan konten yang ada dalam bahasa halaman, dan artikel yang hanya ada dalam satu bahasa dialihkan dari alamat bahasa lain, bukan menampilkan campuran.

#### Beri tahu mesin pencari tentang pasangannya

Dengan dua versi sebuah halaman, mesin pencari perlu tahu bahwa keduanya berpasangan. Setiap halaman menyatakan alamat kanonisnya dan tautan `hreflang` ke kedua versi, dan sitemap mencantumkan setiap versi beserta alternatifnya. Begitulah pencari berbahasa Indonesia diperlihatkan halaman Indonesia dan pencari berbahasa Inggris halaman Inggris.

#### Terjemahkan juga hal-hal kecil

Judul halaman, deskripsi meta, pesan formulir, tanggal, bahkan nama sertifikat butuh versi per bahasa. Mudah terlupa dan jelas terlihat oleh pembaca.

#### Yang akan saya sampaikan kepada pemula

1. Tentukan struktur URL lebih dulu dan jaga konsistensinya.
2. Simpan terjemahan di samping kontennya, bukan di sistem terpisah.
3. Lebih baik menampilkan lebih sedikit dalam satu bahasa daripada menampilkan campuran.
4. Pasang `hreflang` dan tautan kanonis sejak hari pertama.
MD,
            ],
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

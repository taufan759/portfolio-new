# Panel Admin / Admin Panel

Dokumen ini menjelaskan cara masuk dan memakai panel admin. **Password tidak ditulis di sini** karena repo ini ada di GitHub.

## Login

| | |
|---|---|
| URL lokal (Herd) | http://portfolio-new.test/admin/login |
| URL produksi | `https://DOMAIN-ANDA/admin/login` |
| Nama | `Taufan` |
| Email (username) | `taufan759@gmail.com` |
| Password | nilai `ADMIN_PASSWORD` di file `.env` saat seeder pertama kali dijalankan |

- Percobaan login dibatasi **5 kali per menit** per alamat IP.
- Halaman admin tidak diindeks mesin pencari (`noindex`) dan dikecualikan di `robots.txt`.
- Akun dibuat oleh `database/seeders/ContentSeeder.php` dari `ADMIN_EMAIL` dan `ADMIN_PASSWORD` di `.env`. Setelah di produksi, **hapus `ADMIN_PASSWORD` dari `.env`** setelah seed pertama.

## Ganti atau reset password

Jangan menjalankan ulang seeder untuk ini, karena seeder akan menimpa judul, deskripsi, dan urutan proyek yang sudah Anda ubah lewat admin.

```bash
php artisan tinker
```

```php
$u = \App\Models\User::where('email', 'taufan759@gmail.com')->first();
$u->password = 'PASSWORD-BARU-YANG-KUAT';   // otomatis di-hash
$u->save();
```

Untuk menambah admin lain, di tinker: `\App\Models\User::create(['name' => 'Nama', 'email' => 'a@b.com', 'password' => 'rahasia']);`

## Menu admin

| Menu | Fungsi |
|---|---|
| Dashboard | Ringkasan dan tombol **Fetch headlines now** (ambil berita teknologi sekarang) |
| Profile | Teks perkenalan Anda: headline, intro beranda, ringkasan dan cerita di About, lokasi, pendidikan, peran saat ini, dan daftar skill |
| Projects | Proyek: kategori ganda (mis. `fullstack, ai`), `sort`, `is_featured` (4 proyek di beranda), studi kasus Markdown EN/ID |
| Events | Event dan kegiatan di halaman About |
| Gallery | Foto event. Gunakan **Bulk upload** untuk banyak foto sekaligus |
| Collaborations | Logo slider di beranda dan daftar tempat kerja/kolaborasi |
| Certificates | Sertifikat (kolom `title_en` untuk nama versi Inggris) |
| Books | Daftar buku. Status `reading` tampil di beranda |
| Blog posts | Tulisan (Markdown). Isi kolom Inggris dan/atau Indonesia |
| Messages | Pesan dari form kontak (hanya baca) |

## Profile (teks tentang Anda)

Menu **Profile** langsung membuka satu formulir. Setiap teks punya kolom Inggris dan kolom Indonesia (`_id`).

- Kolom yang dikosongkan otomatis memakai teks bawaan di `lang/en/site.php` dan `lang/id/site.php` (bagian `profile`), jadi situs selalu tampil lengkap.
- `story` ditulis dengan **Markdown** (pisahkan paragraf dengan baris kosong).
- `skills` diisi dipisah koma dan sama untuk kedua bahasa.
- Daftar "Organizations and programs" di About ada di `config/site.php` (kunci `orgs`).

## Mengelola banyak proyek

- **Urutan:** angka `sort` lebih kecil tampil lebih dulu. Jika angkanya sama (misalnya semua 0), proyek yang paling baru dibuat tampil di atas.
- **Beranda:** hanya menampilkan 4 proyek yang dicentang `is_featured`. Jika yang dicentang kurang dari 4, sisanya diisi proyek terbaru.
- **Halaman Proyek:** 12 proyek per halaman dengan penomoran, serta filter kategori beserta jumlahnya. Kategori yang kosong tidak ditampilkan.
- **Pencarian (Ctrl/Cmd+K)** mencakup semua proyek yang dipublikasikan.
- **Kategori** tersedia tiga: `fullstack`, `uiux`, `ai`. Untuk menambah kategori baru, ubah daftar pilihan di `config/admin.php`, `ProjectController::CATEGORIES`, dan teks di `lang/*/site.php` (kunci `projects`).
- Gambar proyek disarankan rasio 2:1 (misalnya 1200x600). Bagian atas gambar yang ditampilkan di kartu.

## Dua bahasa (ID / EN)

Setiap konten punya kolom **Inggris (utama)** dan kolom **Indonesia** (berakhiran `_id`).

- Isi keduanya agar halaman muncul di `/id/...` dan `/en/...` lengkap dengan hreflang.
- Jika hanya satu bahasa yang diisi, halaman itu otomatis memakai canonical ke bahasa tersebut dan pengunjung bahasa lain melihat teks yang tersedia.
- Slug sama untuk kedua bahasa. Kosongkan slug agar dibuat otomatis dari judul.
- Proyek: `description` / `description_id` dipakai di kartu dan deskripsi SEO. `details` / `details_id` (Markdown) adalah studi kasus di halaman proyek. Isi ini supaya halaman proyek berbobot untuk SEO.

## Gambar

Unggah JPG/PNG/WebP. Gambar otomatis diperkecil dan diubah ke **WebP** lalu disimpan di `public/images/uploads`.

## Database

| | |
|---|---|
| Jenis | MySQL |
| Nama database | `portfolio` |
| Lokal | host `127.0.0.1`, port `3306`, user `root`, tanpa password (default Herd) |
| Pengaturan | `DB_*` di `.env` (file ini tidak masuk git) |

Buat ulang tabel dari nol (menghapus semua data): `php artisan migrate:fresh --seed`

## Jadwal otomatis

- Berita teknologi diperbarui tiap jam lewat cron `schedule:run`, dan juga otomatis saat beranda atau `/news` dibuka jika datanya lebih dari 60 menit.
- Ambil manual: `php artisan news:fetch`

## Konten per bahasa

- **Tulisan blog:** sebuah tulisan hanya tampil di bahasa yang kolom judulnya terisi. Judul Inggris kosong = hanya di halaman Indonesia (dan sebaliknya). Alamat di bahasa yang tidak tersedia otomatis dialihkan.
- **Berita:** halaman Inggris memakai sumber internasional, halaman Indonesia memakai sumber Indonesia. Daftar sumber dan kata kunci ada di `config/news.php` (kunci `lang` per sumber).

## Perintah yang berguna (Terminal / SSH)

```bash
php artisan medium:import @taufan759      # tarik tulisan baru dari Medium (tanpa duplikat)
php artisan news:fetch                    # ambil berita sekarang
php artisan github:sync                   # perbarui aktivitas GitHub di About
php artisan db:seed --class=PostTranslationSeeder --force   # isi terjemahan Inggris tulisan (hanya kolom yang kosong)
php artisan db:seed --class=ProjectShowcaseSeeder --force   # reset 14 proyek unggulan ke versi terkurasi (menimpa editan proyek itu)
```

## Memperbarui server setelah push

```bash
cd ~/portfolio-new && git pull
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

## SEO

- Isi `SEO_PRIMARY_HOST=taufanakbr.my.id` di `.env` server. Hanya host ini yang diindeks; alamat lain otomatis `noindex`.
- Kode verifikasi Google Search Console: `GOOGLE_SITE_VERIFICATION=kode` di `.env`.
- Berkas otomatis: `/sitemap.xml`, `/robots.txt`, `/llms.txt`, `/llms-full.txt`, `/ai.txt`.

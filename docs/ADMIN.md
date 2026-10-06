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
| Projects | Tambah, ubah, hapus proyek. Satu proyek = satu halaman `/projects/{slug}` |
| Certificates | Sertifikat yang tampil di halaman About |
| Books | Daftar buku. Status `reading` tampil di beranda sebagai "Sedang dibaca" |
| Blog posts | Tulisan blog (Markdown) |
| Messages | Pesan dari form kontak (hanya baca) |

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

<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

/**
 * Reading list. Uses firstOrCreate on the title, so running it again never overwrites edits made in admin.
 */
class BookSeeder extends Seeder
{
    public function run(): void
    {
        // [title, author, status, cover slug]
        $books = [
            ['Prinsipil Ekonomi: Memahami Ekonomi dengan Mudah', 'Ferry Irwandi', 'reading', 'prinsipil-ekonomi'],

            ['Show Your Work!', 'Austin Kleon', 'wishlist', 'show-your-work'],
            ['You Do You: Discovering Life Through Experiments & Self-Awareness', 'Fellexandro Ruby', 'wishlist', 'you-do-you'],

            ['Atomic Habits', 'James Clear', 'finished', 'atomic-habits'],
            ['The Psychology of Money', 'Morgan Housel', 'finished', 'psychology-of-money'],
            ['The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'finished', 'subtle-art-of-not-giving-a-fck'],
            ['Filosofi Teras', 'Henry Manampiring', 'finished', 'filosofi-teras'],
            ['Laut Bercerita', 'Leila S. Chudori', 'finished', 'laut-bercerita'],
            ['Seporsi Mie Ayam Sebelum Mati', 'Brian Khrisna', 'finished', 'seporsi-mie-ayam-sebelum-mati'],
            ['Baca Buku Ini Saat Engkau Ingin Berubah', 'Rahma Kusharjanti', 'finished', 'baca-buku-ini-saat-engkau-ingin-berubah'],
            ['Untuk Kamu yang Malas dan Suka Menunda', 'Noura', 'finished', 'untuk-kamu-yang-malas-dan-suka-menunda'],
            ['Banjir Darah', 'Anab Afifi & Thowaf Zuharon', 'finished', 'banjir-darah'],
        ];

        foreach (array_reverse($books) as [$title, $author, $status, $cover]) {
            Book::firstOrCreate(['title' => $title], [
                'author' => $author,
                'status' => $status,
                'cover' => "images/books/{$cover}.webp",
            ]);
        }
    }
}

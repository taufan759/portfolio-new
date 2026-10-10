<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Curated project list, ordered from strongest to lighter work (the order of $projects below is the display order).
 * Copy is deliberately short and teasing: it hints at what each project does and leaves the rest to the visit.
 * Matches projects by slug and UPDATES them, so run it only to reset these projects to the curated content.
 */
class ProjectShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        $projects = $this->projects();

        foreach ($projects as $i => $p) {
            Project::updateOrCreate(['slug' => $p['slug']], [
                'title' => $p['title'],
                'category' => $p['categories'][0],
                'categories' => $p['categories'],
                'kind' => $p['kind'],
                'year' => $p['year'] ?? null,
                'description' => $p['en'],
                'description_id' => $p['id'],
                'details' => $p['details_en'] ?? null,
                'details_id' => $p['details_id'] ?? null,
                'tags' => $p['tags'],
                'image' => 'images/projects/'.($p['image'] ?? $p['slug']).'.webp',
                'url' => $p['url'] ?? null,
                'sort' => $i,
                'is_published' => true,
                'is_featured' => $i < 6,
            ]);
        }

        // Older projects keep their content; they simply follow the curated ones.
        $next = count($projects);
        foreach (['sd-lumingser-01', 'senada', 'sea-catering', 'bipemas', 'greensaver'] as $slug) {
            Project::where('slug', $slug)->update(['sort' => $next++, 'is_featured' => false]);
        }
        Project::whereIn('slug', ['senada', 'sea-catering'])->update(['year' => 2025]);
        Project::whereIn('slug', ['bipemas', 'greensaver'])->update(['categories' => json_encode(['uiux'])]);
        Project::whereIn('slug', ['sd-lumingser-01', 'sea-catering'])->update(['categories' => json_encode(['fullstack'])]);
        Project::where('slug', 'senada')->update(['categories' => json_encode(['fullstack', 'ai'])]);
    }

    /** @return array<int, array<string, mixed>> */
    private function projects(): array
    {
        return [
            [
                'slug' => 'dbrandainalize', 'title' => 'dbrandAInalize', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Analytics Platform', 'year' => 2026,
                'tags' => ['Laravel', 'AI Integration', 'Data Analytics', 'Chatbot'], 'url' => 'https://sentiment.raycorp.id/',
                'en' => 'What if a brand could read the internet\'s mood in real time, and then ask it questions?',
                'id' => 'Bagaimana kalau sebuah brand bisa membaca suasana hati internet secara real-time, lalu bertanya langsung padanya?',
                'details_en' => <<<'MD'
Millions of conversations, one clear picture. dbrandAInalize listens to what people say about a brand and turns the noise into something a decision-maker can act on in minutes.

#### A glimpse

- **A live pulse** on how a brand is perceived.
- **Executive-ready insight** instead of raw numbers.
- **An assistant** you simply talk to when you want to dig deeper.

Built with Laravel and AI integration. The rest is better seen than described.
MD,
                'details_id' => <<<'MD'
Jutaan percakapan, satu gambaran yang jelas. dbrandAInalize mendengarkan apa yang orang katakan tentang sebuah brand, lalu mengubah keramaian itu menjadi sesuatu yang bisa langsung dipakai untuk mengambil keputusan.

#### Sekilas

- **Denyut real-time** tentang bagaimana brand dipersepsikan.
- **Insight siap eksekutif**, bukan angka mentah.
- **Asisten** yang cukup diajak bicara saat ingin menggali lebih dalam.

Dibangun dengan Laravel dan integrasi AI. Sisanya lebih menarik dilihat langsung.
MD,
            ],
            [
                'slug' => 'lunaray-beauty-factory', 'title' => 'Lunaray Beauty Factory', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI-Powered Corporate Platform', 'year' => 2026,
                'tags' => ['Laravel', 'AI Assistant', 'SEO/AEO/GEO', 'Content Automation'], 'url' => 'https://lunaray.id/',
                'en' => 'A cosmetics factory\'s website that answers back, writes, and publishes on its own.',
                'id' => 'Website pabrik kosmetik yang bisa menjawab, menulis, dan terbit dengan sendirinya.',
                'details_en' => <<<'MD'
More than a company profile: a digital home where service information, an education hub and AI live together, so a visitor can explore, ask and get connected to the team.

#### A glimpse

- **AILUNA**, an assistant that knows Lunaray and points visitors the right way.
- **An AI ecosystem** tying the Product Concept Simulator, Skin Analyzer, AI Wellness and Cantik.ai into one journey.
- **Beautyversity**, an education hub fed by an editorial content pipeline.
- **Found by people and machines**, with SEO, AEO and GEO built in.
- **A custom admin portal** to run it all.

Laravel, MySQL and several AI providers working behind the scenes.
MD,
                'details_id' => <<<'MD'
Lebih dari sekadar company profile: rumah digital tempat informasi layanan, pusat edukasi, dan AI hidup berdampingan, sehingga pengunjung bisa menjelajah, bertanya, dan terhubung dengan tim.

#### Sekilas

- **AILUNA**, asisten yang mengenal Lunaray dan mengarahkan pengunjung ke tempat yang tepat.
- **Ekosistem AI** yang menyatukan Product Concept Simulator, Skin Analyzer, AI Wellness, dan Cantik.ai dalam satu perjalanan.
- **Beautyversity**, pusat edukasi yang disuplai pipeline konten editorial.
- **Mudah ditemukan manusia dan mesin**, dengan SEO, AEO, dan GEO bawaan.
- **Portal admin kustom** untuk mengelola semuanya.

Laravel, MySQL, dan beberapa penyedia AI yang bekerja di balik layar.
MD,
            ],
            [
                'slug' => 'baleide', 'title' => 'Baleide', 'categories' => ['fullstack', 'ai'], 'kind' => 'E-commerce + AI', 'year' => 2026,
                'tags' => ['Laravel', 'MySQL', 'Midtrans', 'AI Chatbot'], 'url' => 'https://baleide.my.id/',
                'en' => 'A bookstore that talks back. Browse, ask, and let the right book find you.',
                'id' => 'Toko buku yang bisa diajak ngobrol. Jelajahi, bertanya, dan biarkan buku yang tepat menemukanmu.',
                'details_en' => <<<'MD'
Baleide is where reading meets conversation. Digital books, a smooth purchase and an assistant that understands what you are in the mood for.

#### A glimpse

- **Ebooks** ready to read the moment they are yours.
- **A chatbot** that recommends instead of just searching.
- **Secure checkout** through Midtrans.

Laravel, MySQL and a little AI magic.
MD,
                'details_id' => <<<'MD'
Baleide adalah tempat membaca bertemu percakapan. Buku digital, pembelian yang mulus, dan asisten yang paham kamu sedang ingin membaca apa.

#### Sekilas

- **Ebook** yang siap dibaca begitu menjadi milikmu.
- **Chatbot** yang merekomendasikan, bukan sekadar mencari.
- **Checkout aman** lewat Midtrans.

Laravel, MySQL, dan sedikit sihir AI.
MD,
            ],
            [
                'slug' => 'raystore', 'title' => 'RayStore', 'categories' => ['fullstack', 'ai'], 'kind' => 'Multi-Role E-commerce', 'year' => 2026,
                'tags' => ['Laravel', 'Midtrans', 'Multi-Role', 'AI Shopping Assistant'], 'url' => 'https://store.raylife.id/store',
                'en' => 'Not just a shop. Customers, affiliates, distributors and dropshippers each walk in through a different door.',
                'id' => 'Bukan sekadar toko. Pelanggan, affiliate, distributor, dan dropshipper masuk lewat pintu yang berbeda.',
                'details_en' => <<<'MD'
A beauty and wellness store where every role gets the experience built for it, from checkout to the dashboard behind it.

#### A glimpse

- **Many roles, one system**, each with its own view.
- **Midtrans checkout** and shipping costs worked out for you.
- **An AI shopping assistant** that helps find the right product.
- **Connected to the company's operations** to keep orders simple.
MD,
                'details_id' => <<<'MD'
Toko kecantikan dan wellness tempat setiap peran mendapat pengalaman yang dirancang untuknya, dari checkout hingga dashboard di baliknya.

#### Sekilas

- **Banyak peran, satu sistem**, masing-masing dengan tampilannya sendiri.
- **Checkout Midtrans** dan ongkos kirim yang dihitung otomatis.
- **Asisten belanja AI** yang membantu menemukan produk yang cocok.
- **Terhubung ke operasional perusahaan** agar pesanan tetap sederhana.
MD,
            ],
            [
                'slug' => 'cantik-ai-wellness-analyzer', 'title' => 'Cantik.AI Wellness Analyzer', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Application', 'year' => 2026,
                'tags' => ['AI Integration', 'n8n', 'Conversational UX', 'Responsive'], 'url' => 'https://wellness.cantik.ai/wellness',
                'en' => 'A few honest answers in, a personal wellness read out. It feels like a conversation, not a form.',
                'id' => 'Beberapa jawaban jujur, lalu hadir gambaran wellness yang personal. Rasanya seperti ngobrol, bukan mengisi formulir.',
                'details_en' => <<<'MD'
Cantik.AI Wellness Analyzer turns a short, friendly exchange into a result that feels made for you. It was shown to the public at Cosmobeauty.

#### A glimpse

- **Conversational flow** that never feels like a questionnaire.
- **AI behind the scenes**, wired through n8n workflows.
- **Made for the phone** first, in the hands of real visitors.

Try it yourself to see what it says about you.
MD,
                'details_id' => <<<'MD'
Cantik.AI Wellness Analyzer mengubah percakapan singkat yang ramah menjadi hasil yang terasa dibuat khusus untukmu. Aplikasi ini diperkenalkan ke publik di Cosmobeauty.

#### Sekilas

- **Alur percakapan** yang tidak pernah terasa seperti kuesioner.
- **AI di balik layar**, terhubung lewat workflow n8n.
- **Dirancang untuk ponsel** dan dipakai langsung oleh pengunjung.

Coba sendiri untuk tahu apa katanya tentang kamu.
MD,
            ],
            [
                'slug' => 'ai-product-concept-simulator', 'title' => 'AI Product Concept Simulator', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Application', 'year' => 2026,
                'tags' => ['AI Integration', 'Multi-step Workflow', 'Reporting', 'Pricing Simulation'], 'url' => 'https://product-concept.lunaray.id/simulator',
                'en' => 'Describe an idea for a product. Watch it become a concept, a price and a report.',
                'id' => 'Ceritakan ide produkmu. Lihat ia berubah menjadi konsep, harga, dan laporan.',
                'details_en' => <<<'MD'
From a rough idea to something you can present, in a few guided steps. The simulator explores what a product could be before anyone spends on making it.

#### A glimpse

- **Guided steps** that sharpen the idea as you go.
- **Pricing simulation** to test how it could land.
- **A ready report** at the end.

Built for the product teams at Lunaray.
MD,
                'details_id' => <<<'MD'
Dari ide mentah menjadi sesuatu yang siap dipresentasikan, hanya lewat beberapa langkah terarah. Simulator ini menjajaki seperti apa sebuah produk bisa jadi sebelum ada biaya produksi.

#### Sekilas

- **Langkah terarah** yang mempertajam ide.
- **Simulasi harga** untuk menguji penerimaannya.
- **Laporan siap pakai** di akhir.

Dibuat untuk tim produk di Lunaray.
MD,
            ],
            [
                'slug' => 'ray-academy', 'title' => 'Ray Academy', 'categories' => ['fullstack'], 'kind' => 'Learning Platform', 'year' => null,
                'tags' => ['Laravel', 'Midtrans', 'Admin Dashboard', 'LMS'], 'url' => 'https://rayacademy.id/',
                'en' => 'A place to learn, a place to teach, and everything in between handled quietly behind the scenes.',
                'id' => 'Tempat untuk belajar, tempat untuk mengajar, dan semua yang di antaranya diurus diam-diam di belakang layar.',
                'details_en' => <<<'MD'
Ray Academy is a learning platform with a calm face and a busy engine: courses, payments and an admin side that keeps it all running.

#### A glimpse

- **A learner experience** that stays out of the way.
- **Payments** through Midtrans.
- **A dashboard** for the people running it.
MD,
                'details_id' => <<<'MD'
Ray Academy adalah platform belajar dengan wajah yang tenang dan mesin yang sibuk: kursus, pembayaran, dan sisi admin yang menjaga semuanya berjalan.

#### Sekilas

- **Pengalaman belajar** yang tidak mengganggu.
- **Pembayaran** lewat Midtrans.
- **Dashboard** untuk tim yang mengelolanya.
MD,
            ],
            [
                'slug' => 'adaptable-consulting', 'title' => 'Adaptable Consulting', 'categories' => ['fullstack'], 'kind' => 'Company Profile + Event Tickets', 'year' => 2024,
                'tags' => ['Laravel', 'Midtrans', 'MySQL', 'Event Ticketing'], 'url' => 'https://adaptableconsulting.id/',
                'en' => 'A company profile that quietly sells out events.',
                'id' => 'Company profile yang diam-diam membuat tiket event ludes.',
                'details_en' => <<<'MD'
A consultancy\'s story on the surface, a ticketing engine underneath. Visitors read, get interested and walk out with a ticket.

#### A glimpse

- **A clean company profile.**
- **Event ticketing** with Midtrans payments.
- **Merchant setup** handled end to end.
MD,
                'details_id' => <<<'MD'
Di permukaan, kisah sebuah konsultan. Di bawahnya, mesin tiket. Pengunjung membaca, tertarik, lalu pulang membawa tiket.

#### Sekilas

- **Company profile** yang rapi.
- **Tiket event** dengan pembayaran Midtrans.
- **Setup merchant** diurus dari awal sampai akhir.
MD,
            ],
            [
                'slug' => 'miemiebrownie', 'title' => 'MiemieBrownie', 'categories' => ['fullstack'], 'kind' => 'E-commerce', 'year' => 2024,
                'tags' => ['Laravel', 'MySQL', 'Midtrans', 'E-commerce'], 'url' => 'https://miemiebrownie.com/',
                'en' => 'You will want brownies by the time you reach checkout.',
                'id' => 'Sampai di halaman checkout, kamu pasti sudah kepingin brownies.',
                'details_en' => <<<'MD'
An online bakery built so the products do the persuading. Brownies, hampers and a checkout that feels as smooth as the batter.

#### A glimpse

- **Catalogue and hampers** worth scrolling.
- **Secure checkout** with Midtrans.
- **Looks right** on every screen.
MD,
                'details_id' => <<<'MD'
Toko roti online yang membiarkan produknya yang membujuk. Brownies, hampers, dan checkout semulus adonannya.

#### Sekilas

- **Katalog dan hampers** yang enak di-scroll.
- **Checkout aman** dengan Midtrans.
- **Tampil pas** di semua layar.
MD,
            ],
            [
                'slug' => 'kang-wendra', 'title' => 'Kang Wendra', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Content Pipeline', 'year' => null,
                'tags' => ['Full-stack', 'AI Integration', 'Sitemap Pipeline', 'Content Automation'], 'url' => 'https://kangwendra.com/',
                'en' => 'A brand site that keeps writing itself a little smarter every day.',
                'id' => 'Website brand yang setiap hari menulis dirinya sedikit lebih cerdas.',
                'details_en' => <<<'MD'
Kang Wendra pairs a personal-brand website with an automated content pipeline. Ideas go in; polished, search-ready pieces come out.

#### A glimpse

- **A pipeline** that reads, rewrites and prepares content.
- **AI** doing the heavy lifting, a human doing the judging.
- **Built for search** from the first line.
MD,
                'details_id' => <<<'MD'
Kang Wendra memadukan website personal brand dengan pipeline konten otomatis. Ide masuk, tulisan rapi yang siap dicari keluar.

#### Sekilas

- **Pipeline** yang membaca, menulis ulang, dan menyiapkan konten.
- **AI** mengerjakan yang berat, manusia yang menilai.
- **Siap SEO** sejak baris pertama.
MD,
            ],
            [
                'slug' => 'raylife', 'title' => 'Raylife', 'categories' => ['fullstack', 'ai'], 'kind' => 'Discovery Platform', 'year' => null,
                'tags' => ['Frontend', 'AI Tools', 'Platform Integration', 'Responsive'], 'url' => 'https://raylife.id/',
                'en' => 'One doorway to a whole world of wellness tools.',
                'id' => 'Satu pintu menuju dunia alat wellness.',
                'details_en' => <<<'MD'
Raylife gathers wellness experiences, some of them AI-powered, behind a single, welcoming entrance.

#### A glimpse

- **Discovery** that feels effortless.
- **AI tools** a tap away.
- **Responsive** from the smallest phone up.
MD,
                'details_id' => <<<'MD'
Raylife menghimpun pengalaman wellness, sebagian berbasis AI, di balik satu pintu masuk yang ramah.

#### Sekilas

- **Penemuan** yang terasa mudah.
- **Alat AI** hanya satu ketukan.
- **Responsif** dari ponsel terkecil.
MD,
            ],
            [
                'slug' => 'custom-photo-booth', 'title' => 'Custom Photo Booth', 'categories' => ['fullstack'], 'kind' => 'Web App', 'year' => null,
                'tags' => ['Full-stack', 'Camera API', 'Image Processing', 'Admin Dashboard'], 'url' => 'https://photobooth.rayandra.com/',
                'en' => 'A photo booth with no booth. Just a browser and a good moment.',
                'id' => 'Photo booth tanpa booth. Cukup browser dan momen yang pas.',
                'details_en' => <<<'MD'
Open it, smile, done. A photo booth that lives in the browser and can be dressed up for any event.

#### A glimpse

- **Straight from the camera**, no app to install.
- **Custom frames** for each occasion.
- **An admin side** to manage it all.
MD,
                'details_id' => <<<'MD'
Buka, senyum, selesai. Photo booth yang hidup di browser dan bisa didandani untuk acara apa pun.

#### Sekilas

- **Langsung dari kamera**, tanpa instal aplikasi.
- **Frame kustom** untuk tiap acara.
- **Sisi admin** untuk mengatur semuanya.
MD,
            ],
            [
                'slug' => 'lain-dunia', 'title' => 'Lain Dunia — Harry Pantja', 'categories' => ['fullstack', 'uiux'], 'kind' => 'Editorial Platform', 'year' => null,
                'tags' => ['Web Development', 'UI/UX', 'Editorial', 'Community Submission'], 'url' => 'https://www.laindunia.com/',
                'en' => 'Photography, told like a film. Scroll slowly.',
                'id' => 'Fotografi yang dituturkan seperti film. Scroll pelan-pelan.',
                'details_en' => <<<'MD'
Lain Dunia is an editorial home for the work of Harry Pantja, designed to be experienced rather than browsed.

#### A glimpse

- **A cinematic feel**, from the first frame.
- **Stories** that unfold as you move.
- **A way for the community** to contribute.
MD,
                'details_id' => <<<'MD'
Lain Dunia adalah rumah editorial bagi karya Harry Pantja, dirancang untuk dialami, bukan sekadar dijelajahi.

#### Sekilas

- **Nuansa sinematik** sejak frame pertama.
- **Cerita** yang terbuka seiring kamu bergerak.
- **Ruang bagi komunitas** untuk berkontribusi.
MD,
            ],
            [
                'slug' => 'dian-indah-abadi', 'title' => 'Dian Indah Abadi', 'categories' => ['fullstack', 'ai'], 'kind' => 'Corporate Website + SEO', 'year' => null,
                'tags' => ['AI-assisted Development', 'Technical SEO', 'llms.txt', 'Responsive'], 'url' => 'https://www.dianindahabadi.com',
                'en' => 'A corporate website made to be found, by people and by AI.',
                'id' => 'Website korporat yang dibuat agar ditemukan, oleh manusia maupun AI.',
                'details_en' => <<<'MD'
A company presence built with search in mind, including the new generation of AI search.

#### A glimpse

- **Technical SEO** done properly.
- **Ready for AI answers**, with llms.txt.
- **Fast and responsive.**
MD,
                'details_id' => <<<'MD'
Kehadiran perusahaan yang dibangun dengan mata pada pencarian, termasuk generasi baru pencarian AI.

#### Sekilas

- **SEO teknis** yang dikerjakan benar.
- **Siap dijawab AI**, lengkap dengan llms.txt.
- **Cepat dan responsif.**
MD,
            ],
            [
                'slug' => 'apotek-parahyangan-suite', 'title' => 'Apotek Parahyangan Suite', 'categories' => ['fullstack', 'uiux'], 'kind' => 'Business Website', 'year' => null,
                'tags' => ['Frontend', 'Responsive Design', 'UI Implementation', 'Maps'], 'url' => 'https://apotekparahyangansuite.com/',
                'en' => 'A pharmacy website that feels more like a boutique.',
                'id' => 'Website apotek yang terasa seperti butik.',
                'details_en' => <<<'MD'
Trustworthy without being sterile. A clean, calm website for a neighbourhood pharmacy.

#### A glimpse

- **Clear and welcoming** layout.
- **Easy to find** on the map.
- **Comfortable on any device.**
MD,
                'details_id' => <<<'MD'
Terpercaya tanpa terasa kaku. Website yang bersih dan tenang untuk apotek lingkungan.

#### Sekilas

- **Tata letak** yang jelas dan ramah.
- **Mudah ditemukan** di peta.
- **Nyaman di perangkat apa pun.**
MD,
            ],
            [
                'slug' => 'dermond-official', 'title' => 'DERMOND Official', 'categories' => ['fullstack', 'uiux'], 'kind' => 'Link-in-Bio Website', 'year' => null,
                'tags' => ['Frontend', 'Video Background', 'Custom UI', 'Responsive'], 'url' => 'https://official.dermond.id/',
                'en' => 'A link-in-bio that behaves like a brand film.',
                'id' => 'Link-in-bio yang tampil seperti film brand.',
                'details_en' => <<<'MD'
One page, one tap away, and a lot of atmosphere. DERMOND\'s link hub with a moving background and a custom interface.

#### A glimpse

- **Video backdrop** that sets the mood.
- **Custom UI**, not a template.
- **Smooth on every phone.**
MD,
                'details_id' => <<<'MD'
Satu halaman, satu ketukan, dan banyak suasana. Pusat tautan DERMOND dengan latar bergerak dan antarmuka kustom.

#### Sekilas

- **Latar video** yang membangun suasana.
- **UI kustom**, bukan template.
- **Mulus di semua ponsel.**
MD,
            ],
            [
                'slug' => 'ptsp-sulsel', 'title' => 'PTSP Sulsel', 'categories' => ['fullstack'], 'kind' => 'Government Service Website', 'year' => 2025,
                'tags' => ['Laravel', 'Public Service', 'Responsive'],
                'en' => 'Public services, brought a little closer to the people they serve.',
                'id' => 'Layanan publik, dibuat sedikit lebih dekat dengan warga yang dilayani.',
                'details_en' => <<<'MD'
A website for a one-stop public service in South Sulawesi, built to make something official feel approachable.
MD,
                'details_id' => <<<'MD'
Website untuk layanan terpadu satu pintu di Sulawesi Selatan, dibuat agar urusan resmi terasa lebih ramah.
MD,
            ],
            [
                'slug' => 'miton', 'title' => 'Miton', 'categories' => ['fullstack'], 'kind' => 'Government Dashboard', 'year' => 2026,
                'tags' => ['Laravel', 'Dashboard', 'Data Monitoring'],
                'en' => 'Budget and performance numbers for an entire regency, finally in one clear view.',
                'id' => 'Angka anggaran dan kinerja satu kabupaten, akhirnya dalam satu tampilan yang jelas.',
                'details_en' => <<<'MD'
A monitoring system for budget realisation and performance of regional government offices (Pemkab Timor Tengah Utara).
MD,
                'details_id' => <<<'MD'
Sistem monitoring realisasi anggaran dan kinerja OPD di lingkungan Pemkab Timor Tengah Utara.
MD,
            ],
        ];
    }
}

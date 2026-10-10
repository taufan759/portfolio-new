<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Curated project list, ordered from strongest to lighter work (the order of $projects below is the display order),
 * with case studies in English and Indonesian. Matches projects by slug and UPDATES them, so run it only to
 * reset these projects to the curated content. Edits made later in admin are not touched by other seeders.
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
                'is_featured' => $i < 4,
            ]);
        }

        // Older projects keep their content; they simply follow the curated ones.
        $next = count($projects);
        foreach (['ptsp-sulsel', 'sd-lumingser-01', 'miton', 'senada', 'sea-catering', 'bipemas', 'greensaver'] as $slug) {
            Project::where('slug', $slug)->update(['sort' => $next++, 'is_featured' => false]);
        }
        Project::whereIn('slug', ['bipemas', 'greensaver'])->update(['categories' => json_encode(['uiux'])]);
        Project::whereIn('slug', ['ptsp-sulsel', 'sd-lumingser-01', 'miton', 'sea-catering'])->update(['categories' => json_encode(['fullstack'])]);
        Project::where('slug', 'senada')->update(['categories' => json_encode(['fullstack', 'ai'])]);
    }

    /** @return array<int, array<string, mixed>> */
    private function projects(): array
    {
        return [
            [
                'slug' => 'dbrandainalize', 'title' => 'dbrandAInalize', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Analytics Platform', 'year' => 2026,
                'tags' => ['Laravel', 'AI Integration', 'Data Analytics', 'Chatbot'], 'url' => 'https://sentiment.raycorp.id/',
                'en' => 'AI-powered social listening and brand intelligence platform: multi-source monitoring, sentiment analytics, executive insights and a knowledge-grounded chatbot.',
                'id' => 'Platform social listening dan brand intelligence berbasis AI: pemantauan multi-sumber, analitik sentimen, executive insight, dan chatbot berbasis pengetahuan.',
                'details_en' => <<<'MD'
dbrandAInalize is a digital-intelligence platform built to analyse reputation and monitor public conversation about Pertamina. It brings news media, social media, blogs and websites into one analytics dashboard, maps positive, negative and neutral sentiment, surfaces reputation issues, and turns the result into information that supports decisions.

#### What it does

- **Multi-source social listening** with search and filtering across digital channels.
- **Sentiment analytics engine** that classifies conversation as positive, negative or neutral.
- **AI executive intelligence**: summaries, key findings, risk interpretation and recommendations drawn from the analysed dataset.
- **Interactive dashboard**: sentiment trends, platform distribution, product analysis and reputation indicators.
- **Audience intelligence** with estimated segments by demographics and interests.
- **Knowledge-grounded AI assistant** that answers questions using the monitoring dataset for April to June 2026.
- **Risk and crisis monitoring**: dominant issues and signals of negative escalation.

#### AI knowledge architecture

Monitoring dataset → data processing → sentiment and insight analysis → knowledge context → AI assistant.

The chatbot's knowledge is built from the analysis data of the monitoring period, so users can ask about sentiment trends, reputation issues and public perception in plain language.

#### Why it matters

The project combines web application development, cross-source data processing, visual analytics and AI integration in one decision-support system. The aim is not only to display data, but to turn a pile of public conversation into structured, searchable information.
MD,
                'details_id' => <<<'MD'
dbrandAInalize adalah platform digital intelligence yang saya kembangkan untuk menganalisis reputasi dan memantau percakapan publik terkait Pertamina. Sistem ini mengumpulkan informasi dari media berita, media sosial, blog, dan website ke dalam satu dashboard analitik, memetakan sentimen positif, negatif, dan netral, mengidentifikasi isu reputasi, lalu menyajikannya sebagai informasi yang mendukung pengambilan keputusan.

#### Yang dikerjakan

- **Social listening multi-sumber** dengan pencarian dan penyaringan data dari berbagai kanal digital.
- **Mesin analitik sentimen** yang mengklasifikasikan percakapan menjadi positif, negatif, dan netral.
- **AI executive intelligence**: ringkasan eksekutif, temuan utama, interpretasi risiko, dan rekomendasi berdasarkan dataset analisis.
- **Dashboard interaktif**: tren sentimen, distribusi platform, analisis produk, dan indikator reputasi.
- **Audience intelligence** berupa estimasi segmentasi audiens berdasarkan demografi dan ketertarikan.
- **Asisten AI berbasis pengetahuan** yang menjawab pertanyaan dengan konteks dataset pemantauan April sampai Juni 2026.
- **Pemantauan risiko dan krisis**: isu dominan dan potensi eskalasi sentimen negatif.

#### Arsitektur pengetahuan AI

Dataset pemantauan → pengolahan data → analisis sentimen dan insight → konteks pengetahuan → asisten AI.

Basis pengetahuan chatbot disusun dari data analisis selama periode pemantauan, sehingga pengguna bisa bertanya tentang tren sentimen, isu reputasi, dan persepsi publik dengan bahasa sehari-hari.

#### Nilai proyek

Proyek ini menggabungkan pengembangan aplikasi web, pengolahan data lintas sumber, analitik visual, dan integrasi model AI dalam satu sistem pendukung keputusan. Fokusnya bukan sekadar menampilkan data, tetapi mengubah kumpulan percakapan publik menjadi informasi yang terstruktur dan mudah ditelusuri.
MD,
            ],
            [
                'slug' => 'baleide', 'title' => 'Baleide', 'categories' => ['fullstack', 'ai'], 'kind' => 'E-commerce + AI', 'year' => 2026,
                'tags' => ['Laravel', 'MySQL', 'Midtrans', 'AI Chatbot'], 'url' => 'https://baleide.my.id/',
                'en' => 'Digital ebook store with an AI book-recommendation assistant, Midtrans payments, an in-browser PDF reader and an admin dashboard with sales analytics.',
                'id' => 'Toko ebook digital dengan asisten rekomendasi buku berbasis AI, pembayaran Midtrans, pembaca PDF di browser, dan dashboard admin dengan analitik penjualan.',
                'details_en' => <<<'MD'
Baleide is a web-based ebook store that combines e-commerce, content management, online payment with Midtrans, and an AI chatbot that recommends books.

Customers browse the catalogue, search by need, add items to the cart, pay online and read the PDF ebook directly on the site.

#### AI book assistant

The chatbot uses an AI model steered by a system prompt and connected to the book catalogue. Asked for "a book about AI", it identifies the need and recommends titles that actually exist in the store, with the information that helps a choice. A conventional catalogue becomes a conversational search, so users do not need to know a title first.

#### Features

- **E-commerce experience**: categories, product search, detail pages, cart, vouchers and checkout.
- **Midtrans payment integration** with transaction status updates.
- **Digital ebook reader** for PDF files in the browser.
- **Admin dashboard and analytics**: customers, ebooks, transactions, revenue and category distribution.
- **Transaction management**: search, payment-status and date filters, order details and printable reports.
- **Content and catalogue management**: ebooks, categories, users, vouchers, articles and tags.

#### Flow

Customer: book discovery → AI recommendation or catalogue search → cart → checkout → Midtrans payment → ebook access.
Admin: catalogue management → order monitoring → payment tracking → sales analytics → reports.
MD,
                'details_id' => <<<'MD'
Baleide adalah platform penjualan ebook digital berbasis web yang menggabungkan e-commerce, manajemen konten, pembayaran online lewat Midtrans, dan chatbot rekomendasi buku berbasis AI.

Pengguna bisa menjelajahi katalog, mencari buku sesuai kebutuhan, memasukkan ke keranjang, membayar online, lalu membaca ebook PDF langsung di website.

#### Asisten buku berbasis AI

Chatbot memakai model AI yang diarahkan lewat system prompt dan dihubungkan dengan katalog buku. Ketika pengguna meminta "buku tentang AI", chatbot mengenali kebutuhannya dan merekomendasikan ebook yang benar-benar tersedia, lengkap dengan informasi yang membantu memilih. Katalog biasa berubah menjadi pencarian lewat percakapan, jadi pengguna tidak perlu tahu judul bukunya lebih dulu.

#### Fitur

- **Pengalaman e-commerce**: kategori, pencarian produk, halaman detail, keranjang, voucher, dan checkout.
- **Integrasi pembayaran Midtrans** dengan pembaruan status transaksi.
- **Pembaca ebook digital** untuk PDF langsung di browser.
- **Dashboard admin dan analitik**: pelanggan, ebook, transaksi, pendapatan, dan distribusi kategori.
- **Manajemen transaksi**: pencarian, filter status pembayaran dan tanggal, detail pesanan, serta laporan yang bisa dicetak.
- **Manajemen konten dan katalog**: ebook, kategori, pengguna, voucher, artikel, dan tag.

#### Alur

Pelanggan: menemukan buku → rekomendasi AI atau pencarian katalog → keranjang → checkout → pembayaran Midtrans → akses ebook.
Admin: kelola katalog → pantau pesanan → lacak pembayaran → analitik penjualan → laporan.
MD,
            ],
            [
                'slug' => 'cantik-ai-wellness-analyzer', 'title' => 'Cantik.AI Wellness Analyzer', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Application', 'year' => 2026,
                'tags' => ['AI Integration', 'n8n', 'Conversational UX', 'Responsive'], 'url' => 'https://wellness.cantik.ai/wellness',
                'en' => 'Adaptive AI wellness consultation: a five-step flow where the AI writes follow-up questions from the user\'s own words and returns a personalised wellness report.',
                'id' => 'Konsultasi wellness berbasis AI yang adaptif: alur lima tahap dengan pertanyaan lanjutan yang disusun AI dari jawaban pengguna, lalu laporan wellness personal.',
                'details_en' => <<<'MD'
Cantik.AI Wellness Analyzer is a web consultation app built around an adaptive conversation. A five-step interactive form is combined with an AI model, integrated through n8n, that writes follow-up questions based on what the user has answered.

Unlike a conventional questionnaire with a fixed path, users describe their complaints in everyday language, and the AI response adapts to that context, so the consultation feels more natural and personal.

#### Features

- **Adaptive AI questioning**: follow-ups generated from the user's input, not static form branching.
- **Natural language input** in the user's own words.
- **n8n AI integration**: answers are processed by an n8n workflow that returns contextual responses.
- **Five-step consultation** with a structured experience.
- **Personalised wellness report**: score, summary, analysis and areas to watch.
- **Actionable recommendations**: activities, daily habits and nutrition based on the assessment.
- **Contextual product matching**, designed to match results with a configured wellness catalogue.
- **Mobile-friendly interface** for consultations on a phone.

#### How it works

User input → AI processing via n8n → contextual follow-up questions → wellness assessment → personalised report → product matching.

#### Technical highlight

The main challenge was connecting the consultation interface to the AI so every question stays relevant to the conversation while the five-step assessment structure is preserved.

*This is an AI-based wellness assessment tool, not a replacement for medical diagnosis or professional consultation.*
MD,
                'details_id' => <<<'MD'
Cantik.AI Wellness Analyzer adalah aplikasi konsultasi wellness berbasis web dengan percakapan yang adaptif. Formulir interaktif lima tahap digabungkan dengan model AI yang diintegrasikan lewat n8n untuk menghasilkan pertanyaan lanjutan berdasarkan jawaban pengguna.

Berbeda dari kuesioner dengan alur tetap, pengguna bisa menjelaskan keluhannya dengan bahasa sehari-hari, lalu respons AI menyesuaikan konteks tersebut sehingga konsultasi terasa lebih natural dan personal.

#### Fitur

- **Pertanyaan adaptif dari AI**: pertanyaan lanjutan dihasilkan dari input pengguna, bukan percabangan formulir statis.
- **Input bahasa natural**: pengguna menyampaikan keluhan dengan kata-katanya sendiri.
- **Integrasi AI lewat n8n**: jawaban diproses oleh workflow n8n yang mengembalikan respons kontekstual.
- **Konsultasi lima tahap** dengan pengalaman yang terstruktur.
- **Laporan wellness personal**: skor, ringkasan kondisi, analisis, dan area yang perlu diperhatikan.
- **Rekomendasi yang bisa dijalankan**: aktivitas, kebiasaan harian, dan nutrisi berdasarkan hasil asesmen.
- **Pencocokan produk kontekstual**, dirancang untuk mencocokkan hasil analisis dengan katalog produk wellness yang dikonfigurasi.
- **Antarmuka ramah ponsel** untuk konsultasi lewat perangkat seluler.

#### Cara kerja

Input pengguna → pemrosesan AI lewat n8n → pertanyaan lanjutan kontekstual → asesmen wellness → laporan personal → pencocokan produk.

#### Sorotan teknis

Tantangan utamanya menghubungkan antarmuka konsultasi dengan AI agar setiap pertanyaan tetap relevan dengan konteks percakapan, sambil mempertahankan struktur asesmen lima tahap.

*Aplikasi ini adalah alat asesmen wellness berbasis AI, bukan pengganti diagnosis atau konsultasi medis profesional.*
MD,
            ],
            [
                'slug' => 'ai-product-concept-simulator', 'title' => 'AI Product Concept Simulator', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Application', 'year' => 2026,
                'tags' => ['AI Integration', 'Multi-step Workflow', 'Reporting', 'Pricing Simulation'], 'url' => 'https://product-concept.lunaray.id/simulator',
                'en' => 'AI tool that turns a cosmetic product idea into a structured concept: ingredients, competitors, pricing simulation, marketing copy and a shareable PDF.',
                'id' => 'Alat AI yang mengubah ide produk kosmetik menjadi konsep terstruktur: bahan aktif, kompetitor, simulasi harga, materi pemasaran, dan PDF yang bisa dibagikan.',
                'details_en' => <<<'MD'
The AI Product Concept Simulator helps brand owners, investors and cosmetics industry people mature a product idea before research and production. It guides users through a five-step simulation: product identity, description and active ingredients, packaging, pricing and a product mockup preview.

#### Features

- **Structured product brief**: needs, target consumer, function, formulation traits and packaging preferences.
- **AI-generated concept**: product description, usage and positioning.
- **Ingredient and scientific intelligence**: active ingredients, functions, safety considerations and journal references to review.
- **Competitor and market intelligence**: competitor comparison, price estimates, segmentation, opportunities and risks.
- **Cost and pricing simulation**: estimated COGS, suggested selling price and margin.
- **AI marketing content**: headlines, copywriting, social captions and visual direction.
- **Product mockup preview** based on packaging and colour choices.
- **PDF and WhatsApp sharing** for discussion with R&D or manufacturing partners.

#### Development focus

AI integration, a multi-step form workflow, structured data processing, dynamic report generation, market-intelligence presentation, pricing calculation and a consultation flow through WhatsApp.

#### Project value

It turns cosmetic ideas that used to be scattered across discussions and documents into one structured digital flow, so users have clearer material for decisions and development consultations.

*AI output is a simulation and an initial recommendation. Formulation, safety, product claims, market data and production feasibility still need expert review.*
MD,
                'details_id' => <<<'MD'
AI Product Concept Simulator membantu calon pemilik brand, investor, dan pelaku industri kosmetik mematangkan ide produk sebelum masuk tahap riset dan produksi. Pengguna dipandu lewat simulasi lima tahap: identitas produk, deskripsi dan bahan aktif, kemasan, harga, dan pratinjau mockup produk.

#### Fitur

- **Product brief terstruktur**: kebutuhan produk, target konsumen, fungsi, karakteristik formulasi, dan preferensi kemasan.
- **Konsep produk dari AI**: deskripsi produk, cara penggunaan, dan positioning.
- **Ingredient dan scientific intelligence**: bahan aktif, fungsi, pertimbangan keamanan, dan referensi jurnal untuk ditinjau.
- **Competitor dan market intelligence**: perbandingan kompetitor, estimasi harga, segmentasi pasar, peluang, dan risiko.
- **Simulasi biaya dan harga**: estimasi COGS, rekomendasi harga jual, dan margin.
- **Konten pemasaran dari AI**: headline, copywriting, caption media sosial, dan arahan visual.
- **Pratinjau mockup produk** berdasarkan pilihan kemasan dan warna.
- **Berbagi lewat PDF dan WhatsApp** untuk diskusi dengan tim R&D atau mitra manufaktur.

#### Fokus pengembangan

Integrasi AI, alur formulir bertahap, pengolahan data terstruktur, pembuatan laporan dinamis, penyajian market intelligence, perhitungan harga, dan alur konsultasi lewat WhatsApp.

#### Nilai proyek

Ide kosmetik yang sebelumnya tersebar di berbagai diskusi dan dokumen menjadi satu alur digital yang terstruktur, sehingga pengguna punya bahan awal yang lebih jelas untuk mengambil keputusan dan berkonsultasi.

*Output AI adalah simulasi dan rekomendasi awal. Validasi formulasi, keamanan, klaim produk, data pasar, dan kelayakan produksi tetap memerlukan pemeriksaan ahli.*
MD,
            ],
            [
                'slug' => 'ray-academy', 'title' => 'Ray Academy', 'categories' => ['fullstack'], 'kind' => 'Learning Platform', 'year' => null,
                'tags' => ['Laravel', 'Midtrans', 'Admin Dashboard', 'LMS'], 'url' => 'https://rayacademy.id/',
                'en' => 'Online learning platform with a public course catalogue, Midtrans payments and an admin dashboard for courses, materials, articles, users and payments.',
                'id' => 'Platform belajar online dengan katalog kursus publik, pembayaran Midtrans, dan dashboard admin untuk kursus, materi, artikel, pengguna, dan pembayaran.',
                'details_en' => <<<'MD'
Ray Academy connects learners with courses, professional instructors and educational content in one integrated system. It has two sides: a public interface to explore courses and articles, and an admin dashboard for running the platform.

Learners browse courses by category, find learning material and pay through the Midtrans payment gateway. Admins manage courses, lessons, articles, categories, users and payments.

#### Features

- **Course management**: courses, categories and learning materials.
- **Midtrans payment integration** for course purchases.
- **Article management**: articles, categories, tags and scheduled publishing.
- **Admin dashboard** with statistics for users, courses, enrolments and content.
- **User management** from the admin panel.
- **Course discovery**: catalogue with categories, instructor information and prices.
- **Responsive interface** for different screen sizes.

#### Architecture

Public website → course discovery → enrolment and payment → learning access.
Admin dashboard → course management → content management → user and payment administration.
MD,
                'details_id' => <<<'MD'
Ray Academy menghubungkan peserta dengan berbagai kursus, instruktur profesional, dan konten edukasi dalam satu sistem terintegrasi. Platform ini punya dua sisi: antarmuka publik untuk menjelajahi kursus dan artikel, serta dashboard admin untuk mengelola operasional.

Peserta menelusuri kursus berdasarkan kategori, menemukan materi, dan membayar lewat payment gateway Midtrans. Admin mengelola kursus, materi, artikel, kategori, pengguna, dan pembayaran.

#### Fitur

- **Manajemen kursus**: kursus, kategori, dan materi pembelajaran.
- **Integrasi pembayaran Midtrans** untuk pembelian kursus.
- **Manajemen artikel**: artikel, kategori, tag, dan penjadwalan publikasi.
- **Dashboard admin** dengan statistik pengguna, kursus, pendaftaran, dan konten.
- **Manajemen pengguna** lewat panel admin.
- **Penemuan kursus**: katalog dengan kategori, informasi instruktur, dan harga.
- **Antarmuka responsif** untuk berbagai ukuran layar.

#### Arsitektur

Website publik → penemuan kursus → pendaftaran dan pembayaran → akses belajar.
Dashboard admin → manajemen kursus → manajemen konten → administrasi pengguna dan pembayaran.
MD,
            ],
            [
                'slug' => 'adaptable-consulting', 'title' => 'Adaptable Consulting', 'categories' => ['fullstack'], 'kind' => 'Company Profile + Event Tickets', 'year' => 2024,
                'tags' => ['Laravel', 'Midtrans', 'MySQL', 'Event Ticketing'], 'url' => 'https://adaptableconsulting.id/',
                'en' => 'Consulting company profile website with online event ticket sales: visitors register and pay through Midtrans, with the merchant account set up for live payments.',
                'id' => 'Website profil perusahaan konsultan dengan penjualan tiket event online: pengunjung mendaftar dan membayar lewat Midtrans, dengan akun merchant yang sudah diurus untuk pembayaran nyata.',
                'details_en' => <<<'MD'
Adaptable Consulting is a company profile website for a consulting firm that also sells event tickets online. Besides presenting services, the team, clients and gallery, the site connects events to **Midtrans**, so visitors can buy tickets and pay online. The Midtrans merchant account has been set up as well.

#### What was built

- **Company profile pages**: about, services, clients, partners, gallery and team, with a clear call to action.
- **Event ticketing**: event pages and an online purchase flow for tickets.
- **Midtrans payments** connected to the ticket purchase.
- **Responsive layout** that works across desktop, tablet and phone.
- **Content that can be updated** without touching the code.

#### Flow

Visitor → event page → ticket selection → Midtrans payment → confirmation.
MD,
                'details_id' => <<<'MD'
Adaptable Consulting adalah website profil perusahaan konsultan yang juga menjual tiket event secara online. Selain menampilkan layanan, tim, klien, dan galeri, website ini menghubungkan event ke **Midtrans**, sehingga pengunjung bisa membeli tiket dan membayar online. Akun merchant Midtrans-nya juga sudah diurus.

#### Yang dibangun

- **Halaman profil perusahaan**: tentang, layanan, klien, mitra, galeri, dan tim, dengan ajakan yang jelas.
- **Tiket event**: halaman event dan alur pembelian tiket online.
- **Pembayaran Midtrans** yang terhubung ke pembelian tiket.
- **Tata letak responsif** untuk desktop, tablet, dan ponsel.
- **Konten yang bisa diperbarui** tanpa menyentuh kode.

#### Alur

Pengunjung → halaman event → pilih tiket → pembayaran Midtrans → konfirmasi.
MD,
            ],
            [
                'slug' => 'miemiebrownie', 'title' => 'MiemieBrownie', 'categories' => ['fullstack'], 'kind' => 'E-commerce', 'year' => 2024,
                'tags' => ['Laravel', 'MySQL', 'Midtrans', 'E-commerce'], 'url' => 'https://miemiebrownie.com/',
                'en' => 'Bakery e-commerce website: product catalogue, hampers, cart, articles and secure Midtrans checkout, designed to work on every screen.',
                'id' => 'Website e-commerce toko roti: katalog produk, hampers, keranjang, artikel, dan checkout Midtrans yang aman, dirancang nyaman di semua layar.',
                'details_en' => <<<'MD'
MiemieBrownie is an online store for a bakery and gift business. It presents the product range (brownies, bolen, dessert boxes and hampers), best sellers and articles, and completes the purchase through a secure Midtrans checkout.

#### What was built

- **Product catalogue** by category with best-seller highlights.
- **Hampers and gifts** presented as their own range.
- **Cart and checkout** connected to the Midtrans payment gateway.
- **Articles** to support the brand and search visibility.
- **Multi-device interface** that keeps the brand look on desktop and phone.
MD,
                'details_id' => <<<'MD'
MiemieBrownie adalah toko online untuk usaha bakery dan hampers. Website menampilkan produk (brownies, bolen, dessert box, dan hampers), produk terlaris, serta artikel, lalu menyelesaikan pembelian lewat checkout Midtrans yang aman.

#### Yang dibangun

- **Katalog produk** per kategori dengan sorotan produk terlaris.
- **Hampers dan hadiah** yang ditampilkan sebagai lini tersendiri.
- **Keranjang dan checkout** yang terhubung ke payment gateway Midtrans.
- **Artikel** untuk mendukung brand dan visibilitas pencarian.
- **Antarmuka multi-perangkat** yang menjaga tampilan brand di desktop maupun ponsel.
MD,
            ],
            [
                'slug' => 'kang-wendra', 'title' => 'Kang Wendra', 'categories' => ['ai', 'fullstack'], 'kind' => 'AI Content Pipeline', 'year' => null,
                'tags' => ['Full-stack', 'AI Integration', 'Sitemap Pipeline', 'Content Automation'], 'url' => 'https://kangwendra.com/',
                'en' => 'Personal-brand website with a cinematic interface and an AI content pipeline that discovers articles through sitemaps and rewrites them for publishing.',
                'id' => 'Website personal branding dengan antarmuka sinematik dan pipeline konten AI yang menemukan artikel lewat sitemap lalu menulis ulang untuk diterbitkan.',
                'details_en' => <<<'MD'
Kang Wendra is a personal-branding website that pairs a cinematic visual interface with an AI-based content management system.

The central piece is an **AI-powered content processing pipeline**: it takes reference content from external sources through sitemaps, processes it with an AI model, and produces rewritten versions for the content workflow. Results can be adjusted before use.

#### Highlights

- **Full-stack development**: interface and back-end integration in one system.
- **Cinematic responsive interface**: editorial layout, layered visuals and contrasting typography.
- **Sitemap-driven content discovery** as a structured source of URLs.
- **Automated content extraction** from source pages.
- **LLM-based transformation**: paraphrasing, restructuring and formatting.
- **Integrated pipeline** from discovery to output, connected to the website's content management.

#### Architecture

Sitemap discovery → URL processing → content extraction → LLM transformation → structured output → content management.

The project treats AI as part of the application infrastructure, not only as a chatbot or text generator in the interface.
MD,
                'details_id' => <<<'MD'
Kang Wendra adalah website personal branding yang memadukan antarmuka visual sinematik dengan sistem pengelolaan konten berbasis AI.

Intinya adalah **pipeline pemrosesan konten berbasis AI**: sistem mengambil referensi konten dari sumber eksternal lewat sitemap, mengolahnya dengan model AI, lalu menghasilkan versi tulisan yang disusun ulang untuk alur pengelolaan konten. Hasilnya tetap bisa disesuaikan sebelum dipakai.

#### Sorotan

- **Pengembangan full-stack**: antarmuka dan integrasi back end dalam satu sistem.
- **Antarmuka sinematik yang responsif**: layout editorial, visual berlapis, dan tipografi kontras.
- **Penemuan konten lewat sitemap** sebagai sumber URL yang terstruktur.
- **Ekstraksi konten otomatis** dari halaman sumber.
- **Transformasi berbasis LLM**: parafrasa, restrukturisasi, dan penyesuaian format.
- **Pipeline terintegrasi** dari penemuan sampai output, terhubung ke pengelolaan konten website.

#### Arsitektur

Penemuan sitemap → pemrosesan URL → ekstraksi konten → transformasi LLM → output terstruktur → manajemen konten.

Proyek ini memperlakukan AI sebagai bagian dari infrastruktur aplikasi, bukan sekadar chatbot atau generator teks di antarmuka.
MD,
            ],
            [
                'slug' => 'raylife', 'title' => 'Raylife', 'categories' => ['fullstack', 'ai'], 'kind' => 'Discovery Platform', 'year' => null,
                'tags' => ['Frontend', 'AI Tools', 'Platform Integration', 'Responsive'], 'url' => 'https://raylife.id/',
                'en' => 'Discovery hub for a beauty, skincare and wellness ecosystem, connecting AI tools, educational content and a product catalogue in one interface.',
                'id' => 'Pusat penemuan untuk ekosistem beauty, skincare, dan wellness yang menghubungkan AI tools, konten edukasi, dan katalog produk dalam satu antarmuka.',
                'details_en' => <<<'MD'
Raylife is the digital navigation hub for a beauty, skincare and wellness ecosystem. Instead of a conventional marketplace, it is a **discovery layer** that connects people to AI tools, educational content and a product catalogue through one interface.

#### What was built

- **AI tools integration**: Skin Analyzer, Wellness AI, AI Specialists and Product Concept behind one access point.
- **Centralised discovery architecture** that unites tools, articles and products without putting every service in one app.
- **Product discovery interface** with information, categories, prices and navigation to the sales platform.
- **Editorial integration**: skincare and wellness articles as part of the exploration journey.
- **Conversational entry point** through the Raybot assistant.
- **Responsive, component-based frontend**.

#### Platform flow

User discovery → AI tools and educational content → product exploration → Raystore.

Separating exploration from transactions lets each service keep a clear development focus while the user experience stays continuous.
MD,
                'details_id' => <<<'MD'
Raylife adalah pusat navigasi digital untuk ekosistem beauty, skincare, dan wellness. Bukan marketplace biasa, melainkan **lapisan penemuan** yang menghubungkan pengguna dengan AI tools, konten edukasi, dan katalog produk lewat satu antarmuka.

#### Yang dibangun

- **Integrasi AI tools**: Skin Analyzer, Wellness AI, AI Specialists, dan Product Concept lewat satu titik akses.
- **Arsitektur penemuan terpusat** yang menyatukan tools, artikel, dan produk tanpa menaruh semua layanan dalam satu aplikasi.
- **Antarmuka penemuan produk** dengan informasi, kategori, harga, dan navigasi menuju platform penjualan.
- **Integrasi editorial**: artikel skincare dan wellness sebagai bagian dari perjalanan eksplorasi.
- **Titik masuk percakapan** lewat asisten Raybot.
- **Frontend responsif berbasis komponen**.

#### Alur platform

Penemuan pengguna → AI tools dan konten edukasi → eksplorasi produk → Raystore.

Memisahkan eksplorasi dari transaksi membuat tiap layanan punya fokus pengembangan yang jelas tanpa memutus pengalaman pengguna.
MD,
            ],
            [
                'slug' => 'custom-photo-booth', 'title' => 'Custom Photo Booth', 'categories' => ['fullstack'], 'kind' => 'Web App', 'year' => null,
                'tags' => ['Full-stack', 'Camera API', 'Image Processing', 'Admin Dashboard'], 'url' => 'https://photobooth.rayandra.com/',
                'en' => 'Browser-based photo booth: two photos from the device camera, frames and filters, photo-strip output, WhatsApp and QR sharing, and an admin panel to rebrand it per event.',
                'id' => 'Photobooth berbasis browser: dua foto dari kamera perangkat, frame dan filter, hasil photo strip, berbagi lewat WhatsApp dan QR, serta panel admin untuk menyesuaikan brand per event.',
                'details_en' => <<<'MD'
Custom Photo Booth is a web-based photo booth for brand activations and events. Visitors take two photos with their device camera, choose a frame and a filter, then save or share the result as a photo strip.

An admin dashboard lets organisers customise brand identity, frames, colours and interface elements, so the same app can be reused for different events without changing code.

#### Features

- **Browser-based camera capture** of two photos.
- **Photo strip generation** into a vertical strip design.
- **Custom frame management**: upload frames, manage the collection and choose the active one.
- **Filters**: Normal, Black and White, Retro and Bright.
- **Brand customisation**: brand name, social accounts, header logo and interface colours.
- **Admin dashboard** for results, frames and display settings.
- **WhatsApp and QR sharing**.
- **Step-by-step flow** from capture to finish.

#### Workflow

Camera capture → frame and filter selection → photo strip generation → save and share.
MD,
                'details_id' => <<<'MD'
Custom Photo Booth adalah photobooth berbasis web untuk aktivasi brand dan event. Pengunjung mengambil dua foto lewat kamera perangkat, memilih frame dan filter, lalu menyimpan atau membagikan hasilnya sebagai photo strip.

Dashboard admin memungkinkan penyelenggara menyesuaikan identitas brand, frame, warna, dan elemen tampilan, sehingga aplikasi yang sama bisa dipakai untuk event berbeda tanpa mengubah kode.

#### Fitur

- **Pengambilan foto lewat kamera browser**, dua foto.
- **Pembuatan photo strip** dalam desain strip vertikal.
- **Manajemen frame**: unggah frame baru, kelola koleksi, dan pilih frame aktif.
- **Filter**: Normal, Hitam Putih, Retro, dan Cerah.
- **Kustomisasi brand**: nama brand, akun media sosial, logo header, dan warna antarmuka.
- **Dashboard admin** untuk hasil foto, frame, dan pengaturan tampilan.
- **Berbagi lewat WhatsApp dan QR Code**.
- **Alur langkah demi langkah** dari pengambilan foto sampai selesai.

#### Alur kerja

Ambil foto → pilih frame dan filter → photo strip → simpan dan bagikan.
MD,
            ],
            [
                'slug' => 'lain-dunia', 'title' => 'Lain Dunia — Harry Pantja', 'categories' => ['fullstack', 'uiux'], 'kind' => 'Editorial Platform', 'year' => null,
                'tags' => ['Web Development', 'UI/UX', 'Editorial', 'Community Submission'], 'url' => 'https://www.laindunia.com/',
                'en' => 'Immersive horror storytelling platform with a "classified archives" interface, case explorer, YouTube integration and a community story submission flow.',
                'id' => 'Platform cerita horor yang imersif dengan antarmuka "classified archives", penjelajah kasus, integrasi YouTube, dan alur pengiriman cerita dari komunitas.',
                'details_en' => <<<'MD'
Lain Dunia is a horror and investigation platform that brings the Lain Dunia identity with Harry Pantja to a more modern, immersive web experience. It combines a story archive, video content, a profile of the host and community contributions in one editorial ecosystem.

The design does not follow a conventional blog. It uses a "classified archives" concept with a dark palette, custom typography, editorial composition and a consistent narrative voice.

#### Features

- **Custom horror UI/UX**: typography, colour and hierarchy that build atmosphere.
- **Editorial content architecture**: Cases and Explore sections.
- **Community story submission**: sender identity, location, narrative, contact details and attachments, curated before publishing.
- **Categorisation and filtering** between experience stories and visual investigations.
- **YouTube content integration**.
- **Character-focused storytelling**: a profile page with a career timeline.
- **Consistent narrative design** across microcopy, titles and buttons.

#### User journey

Discover → explore cases and videos → read stories → submit an experience → editorial curation.
MD,
                'details_id' => <<<'MD'
Lain Dunia adalah platform bertema horor dan investigasi yang saya kembangkan untuk menghadirkan kembali identitas Lain Dunia bersama Harry Pantja dalam pengalaman web yang lebih modern dan imersif. Website ini menggabungkan arsip cerita, konten video, profil tokoh, dan kontribusi komunitas dalam satu ekosistem editorial.

Desainnya tidak mengikuti pola blog biasa. Saya membangun konsep "classified archives" dengan palet gelap, tipografi khusus, komposisi editorial, dan gaya bahasa naratif yang konsisten.

#### Fitur

- **UI/UX horor yang khas**: tipografi, warna, dan hierarki konten yang membangun atmosfer.
- **Arsitektur konten editorial**: bagian Cases dan Explore.
- **Pengiriman cerita dari komunitas**: identitas pengirim, lokasi, narasi, kontak, dan lampiran, dikurasi sebelum terbit.
- **Kategori dan filter** untuk memisahkan cerita pengalaman dan investigasi visual.
- **Integrasi konten YouTube**.
- **Narasi berpusat pada tokoh**: halaman profil dengan timeline karier.
- **Desain naratif yang konsisten** pada microcopy, judul, dan tombol.

#### Perjalanan pengguna

Menemukan → menjelajahi kasus dan video → membaca cerita → mengirim pengalaman → kurasi editorial.
MD,
            ],
            [
                'slug' => 'dian-indah-abadi', 'title' => 'Dian Indah Abadi', 'categories' => ['fullstack', 'ai'], 'kind' => 'Corporate Website + SEO', 'year' => null,
                'tags' => ['AI-assisted Development', 'Technical SEO', 'llms.txt', 'Responsive'], 'url' => 'https://www.dianindahabadi.com',
                'en' => 'Corporate website built with AI-assisted development and prepared for search engines and LLMs with technical SEO, llms.txt, llms-full.txt, ai.txt and robots.txt.',
                'id' => 'Website korporat yang dikerjakan dengan AI-assisted development dan disiapkan untuk mesin pencari dan LLM lewat technical SEO, llms.txt, llms-full.txt, ai.txt, dan robots.txt.',
                'details_en' => <<<'MD'
Dian Indah Abadi is a corporate website built with an AI-assisted development approach. AI sped up the first interface and structure, and the layout, content, components and visual consistency were then adjusted by hand to fit the project.

The work covered more than looks. It also looked at how information can be reached, indexed and understood by search engines and by systems built on large language models.

#### Highlights

- **AI-assisted web development**: faster first implementation, followed by manual integration and refinement.
- **Responsive UI/UX** across desktop, tablet and phone.
- **Technical SEO**: site structure and configuration for crawling and indexing.
- **LLM discoverability**: `llms.txt`, `llms-full.txt` and `ai.txt`.
- **Crawler configuration** with `robots.txt`.
- **Content structure and optimisation**: hierarchy, navigation and information structure that people and automated systems can both use.

#### Approach

AI-generated foundation → manual content synchronisation → UI refinement → SEO and AI crawler configuration → deployment.

It shows how AI can accelerate software engineering while the developer keeps control of implementation, information structure and the final result.
MD,
                'details_id' => <<<'MD'
Dian Indah Abadi adalah website korporat yang saya kerjakan dengan pendekatan AI-assisted development. AI dipakai untuk mempercepat antarmuka dan struktur awal, lalu layout, konten, komponen, dan konsistensi tampilan saya sesuaikan sendiri dengan kebutuhan proyek.

Pengerjaannya tidak hanya soal tampilan, tetapi juga bagaimana informasi bisa diakses, diindeks, dan dipahami oleh mesin pencari maupun sistem berbasis large language model.

#### Sorotan

- **AI-assisted web development**: implementasi awal lebih cepat, dilanjutkan integrasi dan penyempurnaan manual.
- **UI/UX responsif** di desktop, tablet, dan ponsel.
- **Technical SEO**: struktur dan konfigurasi website untuk crawling dan indexing.
- **LLM discoverability**: `llms.txt`, `llms-full.txt`, dan `ai.txt`.
- **Konfigurasi crawler** dengan `robots.txt`.
- **Struktur dan optimasi konten**: hierarki, navigasi, dan struktur informasi yang mudah dipakai pengunjung maupun sistem otomatis.

#### Pendekatan

Fondasi dari AI → sinkronisasi konten manual → penyempurnaan UI → konfigurasi SEO dan crawler AI → deployment.

Proyek ini menunjukkan bagaimana AI bisa mempercepat rekayasa perangkat lunak, sementara kendali atas implementasi, struktur informasi, dan hasil akhir tetap di tangan developer.
MD,
            ],
            [
                'slug' => 'apotek-parahyangan-suite', 'title' => 'Apotek Parahyangan Suite', 'categories' => ['fullstack', 'uiux'], 'kind' => 'Business Website', 'year' => null,
                'tags' => ['Frontend', 'Responsive Design', 'UI Implementation', 'Maps'], 'url' => 'https://apotekparahyangansuite.com/',
                'en' => 'Responsive pharmacy website with a clean, minimal look, four main pages, a contact form, a map and direct WhatsApp access.',
                'id' => 'Website apotek yang responsif dengan tampilan bersih dan minimal, empat halaman utama, formulir kontak, peta, dan akses WhatsApp langsung.',
                'details_en' => <<<'MD'
Apotek Parahyangan Suite is a business website built to give a pharmacy a digital identity through a modern, responsive and easy-to-use interface. The design is clean and minimal, combining the brand's visual identity, typography, intuitive navigation and well-structured information.

The focus was the experience across devices, and making it easy for visitors to find services, location, opening hours and communication channels.

#### Implementations

- **Responsive UI** for desktop, tablet and mobile.
- **Multi-page architecture** with four main pages and consistent navigation.
- **Component-based interface** for reusable, consistent design.
- **Contact form** for easier communication.
- **Location and map integration** to help visitors find the pharmacy.
- **Direct communication** through WhatsApp and social media.
- **Brand-focused UI** with a consistent pink, plum and white palette.
MD,
                'details_id' => <<<'MD'
Apotek Parahyangan Suite adalah website bisnis yang dibangun untuk memberi apotek identitas digital lewat antarmuka yang modern, responsif, dan mudah dipakai. Desainnya bersih dan minimal, memadukan identitas visual brand, tipografi, navigasi yang intuitif, dan informasi yang tertata.

Fokusnya pada pengalaman di berbagai perangkat, serta memudahkan pengunjung menemukan layanan, lokasi, jam operasional, dan kanal komunikasi.

#### Implementasi

- **UI responsif** untuk desktop, tablet, dan mobile.
- **Arsitektur multi-halaman** dengan empat halaman utama dan navigasi yang konsisten.
- **Antarmuka berbasis komponen** agar desain konsisten dan bisa dipakai ulang.
- **Formulir kontak** untuk memudahkan komunikasi.
- **Integrasi lokasi dan peta** untuk membantu pengunjung menemukan apotek.
- **Akses komunikasi langsung** lewat WhatsApp dan media sosial.
- **UI berfokus brand** dengan palet pink, plum, dan putih yang konsisten.
MD,
            ],
            [
                'slug' => 'dermond-official', 'title' => 'DERMOND Official', 'categories' => ['fullstack', 'uiux'], 'kind' => 'Link-in-Bio Website', 'year' => null,
                'tags' => ['Frontend', 'Video Background', 'Custom UI', 'Responsive'], 'url' => 'https://official.dermond.id/',
                'en' => 'Custom link-in-bio website with a video background and interactive link cards, built as a branded alternative to ready-made link pages.',
                'id' => 'Website link-in-bio kustom dengan latar video dan kartu tautan interaktif, dibuat sebagai alternatif bermerek dari halaman tautan siap pakai.',
                'details_en' => <<<'MD'
DERMOND Official is a custom link-in-bio website built as an alternative to ready-made services such as Linktree. It has its own visual identity, a video background, translucent layers and interactive link components.

One page connects the online store, marketplaces, social media, the physical store location and direct contact.

#### Implementations

- **Custom link-in-bio development** that fits the brand.
- **Video background** with an overlay to keep content readable.
- **Responsive UI** tuned for phones and desktop.
- **Custom interactive components**: link cards, icons and interaction effects.
- **Centralised, categorised links** for easier access.
- **Brand-focused design** through colour, typography and interface elements.
MD,
                'details_id' => <<<'MD'
DERMOND Official adalah website link-in-bio kustom yang dibuat sebagai alternatif layanan siap pakai seperti Linktree. Identitas visualnya khusus, dengan latar video, lapisan transparan, dan komponen tautan interaktif.

Satu halaman menghubungkan toko online, marketplace, media sosial, lokasi toko fisik, dan kontak langsung.

#### Implementasi

- **Pengembangan link-in-bio kustom** yang sesuai identitas brand.
- **Latar video** dengan overlay agar konten tetap terbaca.
- **UI responsif** yang dioptimalkan untuk ponsel dan desktop.
- **Komponen interaktif kustom**: kartu tautan, ikon, dan efek interaksi.
- **Tautan terpusat dan terkategori** agar mudah diakses.
- **Desain berfokus brand** lewat warna, tipografi, dan elemen antarmuka.
MD,
            ],
        ];
    }
}

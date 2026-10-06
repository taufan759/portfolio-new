<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['MiemieBrownie', 'fullstack', 'E-commerce', 2024, 'A complete e-commerce platform with product catalog, cart, and secure Midtrans payment integration.', ['Laravel', 'MySQL', 'Midtrans'], 'project-1', 'https://miemiebrownie.com/'],
            ['Adaptable Consulting', 'fullstack', 'Business', 2024, 'A professional consulting website with modern design, service showcase, and client engagement features.', ['Laravel', 'JavaScript', 'MySQL'], 'project-2', 'https://adaptableconsulting.id/'],
            ['SD Lumingser 01', 'fullstack', 'Education', 2024, 'A school information system with announcement management and content tools for staff, parents, and students.', ['Laravel', 'Bootstrap', 'MySQL'], 'project-3', 'https://sdnlumingser01.sch.id/'],
            ['BIPEMAS', 'uiux', 'UX Design', 2024, 'End-to-end UX design for a donation platform: research, journey mapping, and high-fidelity prototypes.', ['Figma', 'User Research', 'Prototyping'], 'project-5', null],
            ['GreenSaver', 'uiux', 'UX Design', 2024, 'Mobile app design for smart waste management with location mapping, scanning, and user engagement.', ['Figma', 'Mobile Design', 'User Testing'], 'project-4', null],
            ['PTSP Sulsel', 'fullstack', 'Government', 2024, 'A public information system supporting integrated government services with transparent, accessible design.', ['Laravel', 'Tailwind', 'MySQL'], 'project-6', 'https://pinrang.kemenag.go.id/ptsp'],
            ['Senada', 'fullstack', 'Finance', 2025, 'A personal finance dashboard with expense tracking, budgeting, and investment monitoring.', ['React.js', 'Express.js', 'Chart.js'], 'project-10', 'https://github.com/taufan759/senada'],
            ['Sea Catering', 'fullstack', 'Catering', 2024, 'A catering application to manage menus, customer orders, and event bookings with an intuitive interface.', ['React.js', 'Firebase', 'Tailwind'], 'project-11', 'https://github.com/taufan759/Sea_Catering'],
            ['Miton', 'fullstack', 'Management', 2024, 'A government financial statement web app handling data management, reporting, and transparent presentation.', ['Laravel', 'Bootstrap', 'WebSocket'], 'project-12', null],
        ];
        foreach ($projects as $i => [$title, $cat, $kind, $year, $desc, $tags, $img, $url]) {
            Project::updateOrCreate(['slug' => Str::slug($title)], [
                'title' => $title, 'category' => $cat, 'kind' => $kind, 'year' => $year,
                'description' => $desc, 'tags' => $tags, 'image' => "images/projects/{$img}.webp",
                'url' => $url, 'sort' => $i, 'is_published' => true,
            ]);
        }

        $certs = [
            ['Coding Camp 2025', 'Dicoding & DBS Foundation', 'dicoding1'],
            ['Studi Independen VI', 'Kampus Merdeka (MSIB)', 'msib'],
            ['Bootcamp UI/UX Designer', 'GreatEdu', 'greatedu2'],
            ['Full Stack Developer', 'PT Nibras Berkah Mulia', 'miemiebrownie1'],
            ['Toefl Prediction Test', 'Lembaga Bahasa UBSI', 'Toefl'],
            ['Advanced Uji Profisiensi Odoo', 'Jidoka', 'Jidoka'],
            ['Belajar Dasar AI', 'Dicoding Indonesia', 'dicoding2'],
            ['Front-End Web untuk Pemula', 'Dicoding Indonesia', 'dicoding3'],
            ['Dasar Git dengan GitHub', 'Dicoding Indonesia', 'dicoding4'],
            ['Data Science dengan Microsoft Fabric', 'Dicoding Indonesia', 'dicoding5'],
            ['Gen AI dengan Microsoft Azure', 'Dicoding Indonesia', 'dicoding7'],
            ['Pengembangan Web Intermediate', 'Dicoding Indonesia', 'dicoding6'],
        ];
        foreach ($certs as $i => [$title, $issuer, $img]) {
            Certificate::updateOrCreate(['title' => $title], [
                'issuer' => $issuer, 'image' => "images/certificates/{$img}.webp", 'sort' => $i,
            ]);
        }

        if ($pw = env('ADMIN_PASSWORD')) {
            User::updateOrCreate(['email' => env('ADMIN_EMAIL', 'taufan759@gmail.com')], [
                'name' => 'Taufan', 'password' => Hash::make($pw),
            ]);
        }
    }
}

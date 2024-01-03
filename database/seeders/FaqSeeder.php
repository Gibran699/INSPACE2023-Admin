<?php

namespace Database\Seeders;
use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content =[
            [
                'question' => 'Kenapa sih perlu ikut INSPACE?',
                'answer' => 'Wajib banget nih bagi kalian buat ikut rangkaian lomba dan acara yang ada di INSPACE Karena kita bakal Dapetin Ilmu yang bermanfaat, Pastinya pengalaman yang berharga, Berhak mendapat hadiah jutaan rupiah dan e-sertifikat',
                'font' => 'fa fa-mouse-pointer',
                'status' => 'deactive',
            ],
            [
                'question' => 'Boleh gak sih peserta mengikuti lebih dari satu lomba?',
                'answer' => 'Boleh dong, setiap peserta diperbolehkan untuk mengikuti lebih dari 1 lomba.',
                'font' => 'fa fa-lightbulb-o',
                'status' => 'deactive',
            ],
            [
                'question' => 'Apa aja sih yang dibutuhkan untuk pendaftaran lomba dan bagaimana cara mendaftarnya?',
                'answer' => 'Berkas yang perlu dilengkapi serta alur pendaftaran untuk mengikuti lomba yang ada di INSPACE 2022 dapat dilihat pada Guidebook masing-masing lomba yang ingin diikuti.',
                'font' => 'fa fa-sitemap',
                'status' => 'deactive',
            ],
            [
                'question' => 'Siapa aja yang boleh ikut dalam perlombaan INSPACE?',
                'answer' => '- Bagi siswa SMA/SMK/MA di seluruh indonesia dapat mengikuti lomba poster infografis<br>- Bagi Mahasiswa/i di seluruh Indonesia dapat mengikuti lomba animasi digital, UI/UX, Business Plan Competition, dan lomba poster infografis',
                'font' => 'fa fa-building',
                'status' => 'deactive',
            ],
            [
                'question' => 'Boleh gak sih mengikuti rangkaian perlombaan secara individu?',
                'answer' => 'Untuk lomba yang dapat diikuti secara individu dapat mendaftarkan diri pada lomba poster infografis, sedangkan untuk lomba animasi digital, UI/UX, dan Busniness Plan Competition dapat diikuti oleh minimal 2 orang/tim',
                'font' => 'fa fa-users',
                'status' => 'deactive',
            ],
            [
                'question' => 'Apakah boleh mengirimkan karya yang pernah diikutsertakan pada perlombaan lain?',
                'answer' => 'Tidak boleh ya, karya yang dikirimkan merupakan karya yang orisinil dan belum pernah dipublikasikan di mana pun.',
                'font' => 'fa fa-mortar-board',
                'status' => 'deactive',
            ],
        ];

        foreach ($content as $data) {
            Faq::create([
                'question' => $data['question'],
                'answer' => $data['answer'],
                'font' => $data['font'],
                'status' => $data['status'],
            ]);
        };
    }
}

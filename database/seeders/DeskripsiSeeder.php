<?php

namespace Database\Seeders;

use App\Models\Deskripsi;
use Illuminate\Database\Seeder;

class DeskripsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *  @return void
     */
    public function run()
    {
        $deskripsi =[
            [
                'content' => 'sistem informasi',
                'tittle' => 'Sistem Informasi',
                'deskripsi' => 'INSPACE (Information System Path to Creativity)',
                'link' => 'https://is.itk.ac.id/',
                'short_description' => 'Program studi Sistem Informasi ITK ditujukan sebagai pusat keunggulan penyelenggaraan pendidikan sistem informasi yang dapat membantu meningkatkan kinerja perusahaan atau organisasi melalui pemanfaatan teknologi informasi. Sistem Informasi adalah bidang ilmu yang mempelajari tentang analisa kebutuhan dan proses bisnis serta desain sistem. Pembelajaran pada sistem informasi fokus pada Organizational Issues & Information Systems serta Application Deployment Configuration.',
            ],
            [
                'content' => 'inspace',
                'tittle' => 'INSPACE (Information System Path to Creativity)',
                'deskripsi' => 'Nama kegiatan yang akan diselenggarakan adalah INSPACE  (Information System Path to Creativity) dengan tema kegiatan yaitu, “The Innovative Spirit of Gen-Z in Optimizing Technology to Carry Out the Nusantara Capital”.',
                'link' => 'qwerty',
                'short_description' => 'INSPACE (Information System Path to Creativity) 2023 merupakan rangkaian kegiatan yang berisi rangkaian lomba dengan Talkshow sebagai acara puncak yang ditujukan kepada masyarakat umum terkhusus pada siswa/i SMA sederajat dan mahasiswa/i seluruh Indonesia. INSPACE sendiri merupakan kegiatan yang diselenggarakan tiap tahunnya oleh Himpunan Mahasiswa Sistem Informasi Institut Teknologi Kalimantan. Kegiatan INSPACE 2023 pada tahun ini akan mengangkat tema “The Innovative Spirit of Gen-Z in Optimizing Technology to Carry Out the Nusantara Capital”. Pada tahun ini INSPACE 2023 terdiri dari empat kegiatan lomba dan Seminar Talkshow. Kegiatan INSPACE 2023 akan dilaksanakan secara hybrid mulai dari kegiatan lomba maupun Seminar Talkshow dikarenakan kondisi Indonesia sudah pulih pasca pandemi Covid-19.',

            ],
        ];

        foreach ($deskripsi as $data) {
            Deskripsi::create([
                'content' => $data['content'],
                'tittle' => $data['tittle'],
                'deskripsi' => $data['deskripsi'],
                'short_description' => $data['short_description']
            ]);
        };
    }
}

<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::insert([
            [
                'name' => 'Badan Pengurus Harian'
            ],
            [
                'name' => 'Acara'
            ],
            [
                'name' => 'Perlengkapan, Keamanan, Dan Perizinan'
            ],
            [
                'name' => 'Sponsorship'
            ],
            [
                'name' => 'Public Relation'
            ],
            [
                'name' => 'Web Development'
            ],
            [
                'name' => 'Kesekretariatan'
            ],
            [
                'name' => 'Dana Usaha'
            ],
            [
                'name' => 'Publikasi, Desain dan Dokumentasi'
            ],
        ]);
    }
}

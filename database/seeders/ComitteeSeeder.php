<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comittee;

class ComitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $web_dev = [
            [
                'nim' => '10211059',
                'name' => "Muhammad Hafidh Ma'ruf",
                'email' => '10211059@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Kepala Divisi',
                'telephone' => '08',
            ],
            [
                'nim' => '10211067',
                'name' => 'Najibullah Muhariri',
                'email' => '10211067@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff Ahli',
                'telephone' => '08',
            ],
            [
                'nim' => '10211025',
                'name' => 'Deka Akillah Sufi',
                'email' => '10211025@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff Ahli',
                'telephone' => '08',
            ],
            [
                'nim' => '10221057',
                'name' => 'Cahya Galur Permana',
                'email' => '10221057@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff',
                'telephone' => '08',
            ],
            [
                'nim' => '10221058',
                'name' => 'Muhammad Daffa Rayhan',
                'email' => '10221058@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff',
                'telephone' => '08',
            ],
            [
                'nim' => '10221027',
                'name' => 'Rahmatullah',
                'email' => '10221027@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff',
                'telephone' => '08',
            ],
            [
                'nim' => '10221034',
                'name' => 'Zidane Alfarizi',
                'email' => '10221034@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff',
                'telephone' => '08',
            ],
            [
                'nim' => '10221006',
                'name' => 'Gibran Ivantry Dilma',
                'email' => '10221006@student.itk.ac.id',
                'password' => bcrypt('password'),
                'division_id' => 6,
                'position' => 'Staff',
                'telephone' => '08',
            ],
        ];

        foreach ($web_dev as $data) {
            Comittee::create([
                'nim' => $data['nim'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'division_id' => $data['division_id'],
                'position' => $data['position'],
                'telephone' => $data['telephone'],
            ]);
        };
    }
}

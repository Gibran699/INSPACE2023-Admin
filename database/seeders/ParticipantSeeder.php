<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'number_id' => '10201063',
                'name' => 'Muhammad Priandani Nur Ikhsan',
                'email' => 'priandani25@gmail.com',
                'password' => bcrypt('password'),
                'telephone' => '08',
            ],
            [
                'number_id' => '10201043',
                'name' => 'Haidar Dzaky Sumpena',
                'email' => 'heydardzaki@gmail.com',
                'password' => bcrypt('password'),
                'telephone' => '08',
            ],
            [
                'number_id' => '10201062',
                'name' => 'Muhammad Nur Rahman',
                'email' => 'rahman@gmail.com',
                'password' => bcrypt('password'),
                'telephone' => '08',
            ],
        ];

        foreach ($data as $row) {
            User::create([
                'number_id' => $row['number_id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => $row['password'],
                'telephone' => $row['telephone'],
            ]);
        }
    }
}

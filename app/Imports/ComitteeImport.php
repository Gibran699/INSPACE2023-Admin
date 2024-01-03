<?php

namespace App\Imports;

use App\Models\Comittee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ComitteeImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Comittee([
            'nim' => $row['nim'],
            'name' => $row['name'],
            'email' => $row['email'],
            'division_id' => $row['division'],
            'position' => $row['position'],
            'telephone' => strval($row['telephone']),
            'password' => bcrypt('password'),
            'is_active' => 1,
        ]);
    }
}

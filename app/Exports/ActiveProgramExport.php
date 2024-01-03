<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ActiveProgramExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];
        $active_programs = Program::where('is_active', 1)->get();

        foreach ($active_programs as $key => $active_program) {
            $sheets[] = new ProgramsExport($active_program);
        }

        return $sheets;
    }
}

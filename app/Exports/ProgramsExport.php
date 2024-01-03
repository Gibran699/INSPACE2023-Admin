<?php

namespace App\Exports;

use App\Models\Program;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProgramsExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $program;

    public function __construct($program)
    {
        $this->program = $program;
    }

    public function view(): View
    {
        return view('exports.programExport', [
            'program' => $this->program
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $alphabet = $event->sheet->getHighestDataColumn();
                $totalRow = $event->sheet->getHighestDataRow();

                if (!$this->program->is_group) {
                    $cellRange = 'A1:'.$alphabet.$totalRow;
                } else {
                    $cellRange = 'A1:'.$alphabet.($this->program->max_team * count($this->program->program_teams)+1);
                }
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $event->sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}

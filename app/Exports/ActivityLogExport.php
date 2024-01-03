<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivityLogExport implements FromCollection, WithStyles, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $res = [];
        $no = 0;
        foreach (ActivityLog::latest()->get() as $activity) {
            $res[] = [
                'no' => ++$no,
                'subject' => $activity->subject,
                'url' => $activity->url,
                'method' => $activity->method,
                'comittee' => $activity->comittee->name,
                'executed_at' => $activity->created_at
            ];
        }

        return collect($res);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->autoSize();
            }
        ];
    }

    public function headings(): array
    {
        return ["No", "Subject", "Url", "Method", 'Comittee', 'Executed At'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}

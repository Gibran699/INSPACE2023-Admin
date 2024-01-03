<?php

namespace App\Exports;

use App\Models\Agenda;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AgendaTicketsParticipantExport implements WithMultipleSheets
{
    use Exportable;

    protected $agenda;
    protected $request_data;

    public function __construct($agenda, $request_data)
    {
        $this->agenda = $agenda;
        $this->request_data = $request_data;
    }

    public function sheets(): array
    {
        $sheets = [];
        $participant_data = [];
        foreach ($this->agenda->tickets as $key => $ticket) {
            if ($this->request_data->has('is_export_ticket')) {
                $sheets[] = new TicketsParticipantExport($ticket);
            }

            if ($this->request_data->has('export_data')) {
                foreach ($ticket->participant_tickets as $key => $participant_ticket) {
                    foreach ($participant_ticket->participants()->whereIn('institusi', $this->request_data->export_data)->get() as $key => $participant) {
                        $participant_data[] = $participant;
                    }
                }
            }
        }
        if ($this->request_data->has('export_data')) {
            $sheets = array_merge([new AgendaParticipantExport($participant_data)], $sheets);
        }


        return $sheets;
    }
}

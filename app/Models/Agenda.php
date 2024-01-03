<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['theme', 'open_registration', 'close_registration', 'short_description', 'link_wa', 'image', 'is_active'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'agenda_id');
    }

    public function getTotalParticipantAgendaAttribute()
    {
        $totalParticipant = 0;
        foreach ($this->tickets as $key => $ticket) {
            $totalParticipant += $ticket->total_participant;
        }

        return $totalParticipant;
    }

    public function getParticipantAttendance($is_checkin)
    {
        $totalParticipant = 0;
        foreach ($this->tickets as $key => $ticket) {
            $totalParticipant += $ticket->filterParticipant($is_checkin);
        }

        return $totalParticipant;
    }
}

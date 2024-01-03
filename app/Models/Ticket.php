<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price','stock', 'benefits', 'user_limit', 'agenda_id'];

    protected $casts = [
        'benefits' => 'array'
    ];

    protected $appends = ['tickets_sold'];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    public function participant_tickets()
    {
        return $this->hasMany(ParticipantTicket::class, 'ticket_id');
    }

    public function getTicketsSoldAttribute()
    {
        return $this->participant_tickets->count();
    }

    public function getTotalParticipantAttribute()
    {
        return $this->filterParticipant(null);
    }

    public function filterParticipant($is_checkin = null)
    {
        $totalParticipant = 0;
        foreach ($this->participant_tickets as $key => $participant_ticket) {
            if ($is_checkin === null) {
                $totalParticipant += $participant_ticket->participants->count();
            } elseif ($is_checkin == 1) {
                $totalParticipant += $participant_ticket->participants->where('is_checkin', $is_checkin)->count();
            } else {
                $totalParticipant += $participant_ticket->participants->where('is_checkin', $is_checkin)->count();
            }
        }

        return $totalParticipant;
    }

    public function getTotalIncomeAttribute()
    {
        return $this->participant_tickets->count() * $this->price;
    }
}

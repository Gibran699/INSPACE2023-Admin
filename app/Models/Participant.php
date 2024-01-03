<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'no_hp', 'email', 'institusi', 'participant_ticket_id', 'is_checkin'];

    public function participantTicket()
    {
        return $this->belongsTo(ParticipantTicket::class, 'participant_ticket_id');
    }
}

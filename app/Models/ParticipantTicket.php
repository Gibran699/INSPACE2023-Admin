<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ParticipantTicket extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'paymen_proof', 'is_paid', 'is_checkin', 'check_in_datetime'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'participant_ticket_id');
    }

    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class, 'participant_addons', 'participant_ticket_id', 'addons_id')->withPivot('stock');
    }

    public function getTotalPriceAttribute()
    {
        $totalPrice = 0;
        foreach ($this->addons as $key => $addon) {
            $totalPrice += ($addon->pivot->stock * $addon->addonVariant->price);
        }
        $totalPrice += $this->ticket->price;

        return $totalPrice;
    }
}

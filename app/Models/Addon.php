<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'stock', 'id_addon_variant'];

    protected $appends = ['addon_sold'];

    public function addonVariant()
    {
        return $this->belongsTo(AddonVariant::class, 'id_addon_variant');
    }

    public function participantTickets(): BelongsToMany
    {
        return $this->belongsToMany(ParticipantTicket::class, 'participant_addons', 'addons_id', 'participant_ticket_id')->withPivot('stock');
    }

    public function getAddonSoldAttribute()
    {
        return $this->participantTickets->sum('pivot.stock');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantAddon extends Model
{
    use HasFactory;

    protected $fillable = ['participant_ticket_id', 'addons_id', 'stock'];


}

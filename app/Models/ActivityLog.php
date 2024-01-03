<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function comittee() {
        return $this->belongsTo(Comittee::class, 'comittee_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;
    protected $fillable = ['comittee_id', 'otp'];

    public function comittee()
    {
        $this->belongsTo(Comittee::class, 'comittee_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Program;

class Comittee extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nim',
        'name',
        'email',
        'password',
        'division_id',
        'position',
        'telephone',
        'is_active',
    ];

    protected $hidden = ['password',  'remember_token'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function division() {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function isWebDev() {
        return $this->division->name == 'Web Development';
    }

    public function verificationCode(){
        return $this->hasMany(VerificationCode::class, 'comittee_id');
    }
}

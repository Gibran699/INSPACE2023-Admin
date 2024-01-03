<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'accessmenu'];
    protected $casts = [
        'accessmenu' => 'array',
    ];

    public function comittee() {
        return $this->hasMany(Comittee::class, 'division_id');
    }
}

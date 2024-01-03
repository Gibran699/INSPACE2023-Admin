<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medpart extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['nama_medpart', 'gambar', 'is_active'];
    // protected $timestampa = false;

}

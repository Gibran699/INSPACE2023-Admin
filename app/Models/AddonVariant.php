<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddonVariant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'is_active'];

    public function addons()
    {
        return $this->hasMany(Addon::class, 'id_addon_variant');
    }
}

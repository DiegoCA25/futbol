<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = ['country'];

    // Relación con Team (ya está definida)
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    // Relación con Player (nacionalidad)
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'nationality');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;
    protected $fillable=['name','league', 'country_id'];

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_team');
    }
    public function country(): BelongsTo{
        return $this->belongsTo(Country::class);
    }
}

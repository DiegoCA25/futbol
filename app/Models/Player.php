<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    use HasFactory;
    protected $fillable=['first_name', 'last_name', 'age', 'position', 'description', 'nationality', 'image'];
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'player_team');
    }
}

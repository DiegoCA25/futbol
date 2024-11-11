<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear países y equipos
        \App\Models\Country::factory(50)->create();
        \App\Models\Team::factory(30)->create();

        // Crear jugadores
        $players = Player::factory(25)->create();

        // Asociar 15 jugadores a equipos aleatorios
        foreach ($players->take(15) as $player) {
            // Asociar cada jugador con un equipo aleatorio
            $player->teams()->attach(random_int(1, 30));
        }
    }
}

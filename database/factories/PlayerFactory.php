<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName, // Primer nombre del jugador
            'last_name' => $this->faker->lastName, // Apellido del jugador
            'age' => $this->faker->numberBetween(18, 40), // Edad entre 18 y 40 años
            'position' => $this->faker->randomElement(['Forward', 'Midfielder', 'Defender', 'Goalkeeper']), // Posición en el campo
            'description' => $this->faker->text(100),
            'nationality' => $this->faker->country, // Nacionalidad del jugador
            'image' => '/img/example.png'
        ];
    }
}

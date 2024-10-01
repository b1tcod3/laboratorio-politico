<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TipoOrganizacionEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organizacion>
 */
class OrganizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $tipos = TipoOrganizacionEnum::values();
        asort($tipos);

        return [
            'nombre' => fake()->name(),
            'logo' => fake()->image(null, 360, 360, 'animals', true),
            'tipo' => $tipos[0],
            'acronimo' => 'ABC'
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizationUnit>
 */
class OrganizationUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'pluck_code' => $this->faker->unique()->bothify('??##'),
            'type' => $this->faker->randomElement(['division', 'subdivision', 'group']),
            'parent_id' => null,
            'is_active' => true,
        ];
    }
}

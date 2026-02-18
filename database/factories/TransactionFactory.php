<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_number' => $this->faker->unique()->numerify('TX###'),
            'transaction_date' => $this->faker->date(),
            'branch_id' => $this->faker->randomNumber(),
            'division_id' => $this->faker->randomNumber(),
            'region_code' => $this->faker->stateAbbr(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}

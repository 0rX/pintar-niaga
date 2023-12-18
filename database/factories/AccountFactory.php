<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (Company::all()->count() > 0) {
            $companytotal = Company::all()->count();
        } else {
            $companytotal = 1;
        }

        return [
            'name' => fake()->name(),
            'description' => Str::random(45),
            'company_id' => fake()->numberBetween(1, $companytotal),
            'balance' => 0,
        ];
    }
}

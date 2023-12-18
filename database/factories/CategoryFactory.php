<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'company_id' => fake()->numberBetween(1, $companytotal),
            'description' => Str::random(45),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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

        if (Category::all()->count() > 0) {
            $categorytotal = Category::all()->count();
        } else {
            $categorytotal = 1;
        }

        return [
            'name' => fake()->name(),
            'category_id' => fake()->numberBetween(1, $categorytotal),
            'company_id' => fake()->numberBetween(1, $companytotal),
            'description' => Str::random(45),
            'sale_price' => fake()->numberBetween(15000, 20000),
        ];
    }
}

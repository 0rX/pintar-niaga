<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (User::all()->count() > 0) {
            $usertotal = User::all()->count();
        } else {
            $usertotal = 1;
        }

        $name = fake()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'user_id' => fake()->numberBetween(1, $usertotal),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'is_active' => 'true',
            'description' => Str::random(45),
        ];
    }
}

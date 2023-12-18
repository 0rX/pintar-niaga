<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\Position::factory()->create([
        //     'name' => 'unsigned',
        //     'description' => 'Staff yang belum mendapatkan penempatan posisi'
        // ]);

        Models\User::factory()->create([
            'name' => 'Komisaris VDG',
            'email' => 'komisaris@vegasdelta.com',
            'phone' => '081234567890',
            'address' => 'Jl. Pegangsaan Timur no.72, Kelapa Gading, Jakarta Utara',
            'birthdate' => '1995-01-12',
            'gender' => 'male',
            'profilepicture' => null,
            'gender' => 'male',
            'is_active' => 'true',
            'profilepicture' => null,
            'password' => Hash::make('password'),
        ]);

        Models\User::factory(5)->create();
        
        Models\Company::factory()->create([
            'user_id' => 1,
            'name' => 'Vegas Delta',
            'slug' => 'vegas-delta',
            'address' => 'Jl. Pegangsaan Timur no.72 Kelapa Gading Jakarta Utara',
            'phone' => '081234567890',
            'email' => 'komisaris@vegasdelta.com',
            'logo' => null,
            'website' => null,
            'description' => null,
            'is_active' => 'true',
        ]);

        Models\Company::factory(2)->create();

        Models\Category::factory()->create([
            'company_id' => 1,
            'name' => 'makanan',
            'description' => 'Produk makanan kemasan',
        ]);

        Models\Category::factory(3)->create();

        Models\Product::factory()->create([
            'company_id' => 1,
            'name' => 'indomie',
            'category_id' => 1,
            'sale_price' => 7000,
            'description' => 'Indomie Goreng Original',
            'image' => null,
        ]);

        Models\Product::factory(10)->create();

        Models\Account::factory()->create([
            'company_id' => 1,
            'name' => 'cash',
            'balance' => 0,
        ]);

        Models\Account::factory(1)->create();
    }
}

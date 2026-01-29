<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@ultranet.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // Seed Categories
        $this->call(CategorySeeder::class);

        // Create Products
        $categoryIds = Category::pluck('id')->toArray();

        foreach ($categoryIds as $categoryId) {
            Product::factory()->count(rand(5, 10))->create([
                'category_id' => $categoryId
            ]);
        }
    }
}
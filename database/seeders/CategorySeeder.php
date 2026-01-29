<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Home & Garden',
            'Sports & Outdoors',
            'Toys & Games',
            'Beauty & Health',
            'Automotive',
            'Food & Beverage',
            'Office Supplies'
        ];

        foreach ($categories as $categoryName) {
            Category::updateOrCreate(['name' => $categoryName]);
        }
    }
}
<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // iPhone 15 Series
            ['name' => 'iPhone 15', 'series' => 'Pro Max'],
            ['name' => 'iPhone 15', 'series' => 'Pro'],
            ['name' => 'iPhone 15', 'series' => 'Plus'],
            ['name' => 'iPhone 15', 'series' => 'Standard'],

            // iPhone 14 Series
            ['name' => 'iPhone 14', 'series' => 'Pro Max'],
            ['name' => 'iPhone 14', 'series' => 'Pro'],
            ['name' => 'iPhone 14', 'series' => 'Plus'],
            ['name' => 'iPhone 14', 'series' => 'Standard'],

            // iPhone 13 Series
            ['name' => 'iPhone 13', 'series' => 'Pro Max'],
            ['name' => 'iPhone 13', 'series' => 'Pro'],
            ['name' => 'iPhone 13', 'series' => 'Mini'],
            ['name' => 'iPhone 13', 'series' => 'Standard'],

            // iPhone 12 Series
            ['name' => 'iPhone 12', 'series' => 'Pro Max'],
            ['name' => 'iPhone 12', 'series' => 'Pro'],
            ['name' => 'iPhone 12', 'series' => 'Mini'],
            ['name' => 'iPhone 12', 'series' => 'Standard'],

            // iPhone 11 Series
            ['name' => 'iPhone 11', 'series' => 'Pro Max'],
            ['name' => 'iPhone 11', 'series' => 'Pro'],
            ['name' => 'iPhone 11', 'series' => 'Standard'],

            // iPhone XS Series
            ['name' => 'iPhone XS', 'series' => 'Max'],
            ['name' => 'iPhone XS', 'series' => 'Standard'],

            // iPhone XR
            ['name' => 'iPhone XR', 'series' => 'Standard'],

            // iPhone X
            ['name' => 'iPhone X', 'series' => 'Standard'],

            // iPhone 8 Series
            ['name' => 'iPhone 8', 'series' => 'Plus'],
            ['name' => 'iPhone 8', 'series' => 'Standard'],

            // iPhone 7 Series
            ['name' => 'iPhone 7', 'series' => 'Plus'],
            ['name' => 'iPhone 7', 'series' => 'Standard'],
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name'] . ' ' . $category['series']);

            Category::create([
                'name' => $category['name'],
                'series' => $category['series'],
                'slug' => $slug,
            ]);
        }
    }
}

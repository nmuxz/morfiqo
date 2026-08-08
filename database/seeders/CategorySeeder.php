<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Kemeja',
            'Kaos',
            'Jaket',
            'Celana Jeans',
            'Celana Chino',
            'Rok',
            'Dress',
            'Lainnya'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'slug' => Str::slug($category)
            ], [
                'name' => $category
            ]);
        }
    }
}

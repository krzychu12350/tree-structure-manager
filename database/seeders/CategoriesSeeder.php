<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        $categories = [
            [
                'name' => 'C',
                'parent_id' => null,
            ],
            [
                'name' => 'Program Files',
                'parent_id' => 1,
            ],
            [
                'name' => 'Users',
                'parent_id' => 1,
            ],
            [
                'name' => 'Krzychu',
                'parent_id' => 3,
            ],
            [
                'name' => 'Desktop',
                'parent_id' => '4',
            ],
            [
                'name' => 'Documents',
                'parent_id' => '4',
            ],
            [
                'name' => 'Public',
                'parent_id' => 3,
            ],
            [
                'name' => 'Windows',
                'parent_id' => 1,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'parent_id' => $category['parent_id'],
            ]);
        }
    }
}

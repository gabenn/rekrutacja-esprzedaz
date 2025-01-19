<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'id' => 1,
            'name' => 'A',
        ]);
        Category::create([
            'id' => 2,
            'name' => 'B',
        ]);
        Category::create([
            'id' => 3,
            'name' => 'C',
        ]);
    }
}

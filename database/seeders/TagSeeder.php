<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        Tag::create([
            'id' => 1,
            'name' => 'Tag 1',
        ]);
        Tag::create([
            'id' => 2,
            'name' => 'Tag 2',
        ]);
        Tag::create([
            'id' => 3,
            'name' => 'Tag 3',
        ]);
    }
}

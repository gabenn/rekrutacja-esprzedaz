<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PetStatus;
use App\Models\Pet;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    public function run()
    {
        $pet1 = Pet::create([
            'id' => 1,
            'name' => 'Pet 1',
            'photo_urls' => ['url1', 'url2'],
            'category_id' => 1,
            'status' => PetStatus::AVAILABLE,
        ]);
        $pet1->tags()->attach([1, 2]);

        Pet::create([
            'id' => 2,
            'name' => 'Pet 2',
            'photo_urls' => [],
            'category_id' => 2,
            'status' => PetStatus::AVAILABLE,
        ]);

        Pet::create([
            'id' => 3,
            'name' => 'Pet 3',
            'photo_urls' => ['url1'],
            'category_id' => 3,
            'status' => PetStatus::SOLD,
        ]);

    }
}

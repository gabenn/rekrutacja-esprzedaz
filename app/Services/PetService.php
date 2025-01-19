<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Pet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetService
{
    /**
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPets(int $perPage = 10)
    {
        return Pet::with(['category', 'tags'])->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Pet
     */
    public function createPet(array $data): Pet
    {
        $pet = Pet::create($data);
        if (isset($data['tags'])) {
            $pet->tags()->attach($data['tags']);
        }
        return $pet;
    }

    /**
     * @param int $id
     * @return Pet
     *
     * @throws ModelNotFoundException
     */
    public function getPetById(int $id): Pet
    {
        return Pet::with(['category', 'tags'])->findOrFail($id);
    }

    /**
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPetsByStatus(string $status)
    {
        return Pet::with(['category', 'tags'])->where('status', $status)->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return Pet
     *
     * @throws ModelNotFoundException
     */
    public function updatePet(int $id, array $data): Pet
    {
        $pet = Pet::with(['category', 'tags'])->findOrFail($id);
        $pet->update($data);

        if (isset($data['tags'])) {
            $pet->tags()->sync($data['tags']);
        }

        return $pet;
    }

    /**
     * @param int $id
     * @return void
     *
     * @throws ModelNotFoundException
     */
    public function deletePet(int $id): void
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();
    }
}

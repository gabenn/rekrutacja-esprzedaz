<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Pet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetService
{
    /**
     * Pobiera listę wszystkich zwierząt z ich kategoriami i tagami, z paginacją.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllPets(int $perPage = 10)
    {
        return Pet::with(['category', 'tags'])->paginate($perPage);
    }

    /**
     * Tworzy nowe zwierzę i przypisuje tagi (jeśli są podane).
     *
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
     * Pobiera szczegóły zwierzęcia według ID.
     *
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
     * Pobiera zwierzeta według statusu.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPetsByStatus(string $status)
    {
        return Pet::with(['category', 'tags'])->where('status', $status)->get();
    }

    /**
     * Aktualizuje dane zwierzęcia i synchronizuje tagi.
     *
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
     * Usuwa zwierzę według ID.
     *
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

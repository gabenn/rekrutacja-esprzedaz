<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePetRequest;
use App\Http\Requests\DeletePetRequest;
use App\Http\Requests\GetPetByStatusRequest;
use App\Http\Requests\GetPetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Http\Resources\PetResource;
use App\Services\PetService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PetController extends Controller
{
    private PetService $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index(Request $request): View
    {
        $pets = $this->petService->getAllPets(10);
        return view('index', ['pets' => PetResource::collection($pets)]);
    }

    public function create(Request $request): View
    {
        return view('create');
    }

    public function store(CreatePetRequest $request): \Illuminate\Http\JsonResponse
    {
        $pet = $this->petService->createPet($request->validated());
        return response()->json(new PetResource($pet), Response::HTTP_CREATED);
    }

    public function show(GetPetRequest $request, int $pet): \Illuminate\Http\JsonResponse
    {
        try {
            $item = $this->petService->getPetById($pet);
            return response()->json(new PetResource($item), Response::HTTP_OK);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(Request $request, int $pet): View
    {
        try {
            $item = $this->petService->getPetById($pet);
            return view('edit', ['pet' => new PetResource($item)]);
        } catch (ModelNotFoundException $e) {
            return view('edit', ['pet' => null]);
        }
    }

    public function update(UpdatePetRequest $request, int $pet): \Illuminate\Http\JsonResponse
    {
        try {
            $item = $this->petService->updatePet($pet, $request->validated());
            return response()->json(new PetResource($item), Response::HTTP_OK);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy(DeletePetRequest $request, int $pet): \Illuminate\Http\JsonResponse
    {
        try {
            $this->petService->deletePet($pet);
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function getPetsByStatus(GetPetByStatusRequest $request, string $status): \Illuminate\Http\JsonResponse
    {
        $pets = $this->petService->getPetsByStatus($status);
        return response()->json(PetResource::collection($pets), Response::HTTP_OK);
    }
}

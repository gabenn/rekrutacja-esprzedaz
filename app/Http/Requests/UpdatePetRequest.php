<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdatePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['pet' => $this->route('pet')]);

        if (is_string($this->photo_urls)) {
            $this->merge(['photo_urls' => explode(',', $this->photo_urls)]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pet' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'category_id' => ['nullable', 'integer'],
            'photo_urls' => ['required', 'array'],
            'tags' => ['nullable', 'array'],
            'status' => ['nullable', 'string', 'in:available,pending,sold'],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator):void
    {
        $response = response()->json([
            'errors' => 'Invalid ID supplied',
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
}



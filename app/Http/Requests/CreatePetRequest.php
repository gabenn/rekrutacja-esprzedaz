<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CreatePetRequest extends FormRequest
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
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'errors' => 'Invalid input',
        ], Response::HTTP_METHOD_NOT_ALLOWED);

        throw new HttpResponseException($response);
    }
}

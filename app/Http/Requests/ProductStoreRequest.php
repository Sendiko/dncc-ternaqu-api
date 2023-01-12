<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:products,title'],
            'description' => ['required', 'string'],
            'benefits' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1'],
            'brand' => ['required', 'string', 'max:255'],
            'store_id' => ['required', 'numeric', 'min:1'],
            'imageUrl' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ];
    }

    /**
     * Custom error message for authorization
     *
     * @return array
     */
    public function failedAuthorization()
    {
        $response = response()->json([
            'status' => 401,
            'message' => 'Unauthorized Access',
            'error' => 'You dont have right access'
        ], 201);

        abort($response);
    }

    /**
     * Custom error message for validation
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'status' => 422,
            'message' => 'Server Error',
            'error' => $errors->messages()
        ], 201);

        abort($response);
    }
}

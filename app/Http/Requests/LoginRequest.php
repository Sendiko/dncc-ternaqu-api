<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // check if user is authenticated
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email:dns', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255']
        ]; // validation rules
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
        ], 201); // custom response

        abort($response); // abort with custom response
    }

    /**
     * Custom error message for validation
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); // get errors

        $response = response()->json([
            'status' => 422,
            'message' => 'Server Error',
            'error' => $errors->messages() // get error messages
        ], 201); // custom response

        abort($response); // abort with custom response
    }
}

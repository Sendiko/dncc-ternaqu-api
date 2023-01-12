<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TopicStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->check(); // check if user is authenticated
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255', 'unique:topics,title'],
            'question' => ['required', 'string', 'max:255'],
            'replyTo' => ['required', 'numeric']
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

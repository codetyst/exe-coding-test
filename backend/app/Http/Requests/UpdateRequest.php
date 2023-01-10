<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'regex:/^[a-zA-Z ]*$/',
            'phone' => 'regex:/^[0-9(]+[0-9() -]+$/',
            'email' => 'required|email|exists:exe_users,email',
            'newEmail' => 'email|unique:exe_users,email',
            'username' => 'regex:/^[a-zA-Z]+[a-zA-Z0-9\.\_]*$/',
            'company' => 'regex:/^[a-zA-Z0-9\.\,\- ]*$/',
            'nationality' => 'regex:/^[a-zA-Z ]*$/'
        ];
    }

    public function failedValidation(Validator $validator)

    {
        $response = response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()

        ]);
        Log::error('[UpdateRequest::failedValidation]' . ' Status: ' . $response);
        throw new HttpResponseException($response);
    }
}

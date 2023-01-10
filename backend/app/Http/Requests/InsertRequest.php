<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Log;

class InsertRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'phone' => 'required|regex:/^[0-9(]+[0-9() -]+$/',
            'email' => 'required|email|unique:exe_users,email',
            'password' => 'required',
            'username' => 'required|regex:/^[a-zA-Z]+[a-zA-Z0-9\.\_]*$/',
            'company' => 'required|regex:/^[a-zA-Z0-9\.\,\- ]*$/',
            'nationality' => 'required|regex:/^[a-zA-Z ]*$/'
        ];
    }

    public function failedValidation(Validator $validator)

    {
        $response = response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()

        ]);
        Log::error('[InsertRequest::failedValidation]' . ' Status: ' . $response);
        throw new HttpResponseException($response);
    }
}

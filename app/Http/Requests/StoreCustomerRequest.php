<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'ic' => 'required',
            'matric' => 'required',
            'phone' => 'required|max:15',
            'college' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'bank' => 'required|string|max:255',
            'acc_num' => 'required|string|max:255',
        ];
    }
}

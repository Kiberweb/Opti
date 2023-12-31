<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedBackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|min:3|max:57',
            'phone' => 'required|regex:/^\+38[\-\(\)\d]+/im|min:18',
//            'phone' => 'required|numeric',
            'city_id' => 'required|exists:cities,id',
            'feedback' => 'required|string|min:7',
        ];
    }
//'phone' => 'required|regex:/^\+38[\-\(\)\d]+/im|min:18',
}

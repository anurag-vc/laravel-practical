<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['nullable','email', 'max:255',
                Rule::unique('companies')->ignore($this->company),
            ],
            'logo' => ['image','mimes:jpg,png,jpeg', 'dimensions:min_width=100,min_height=100']
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'service' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'mimes:jpeg,jpg,png,gif',
            'offer.*' => 'required|string|max:255',
            'price.*' => 'required|integer'

        ];
    }
}

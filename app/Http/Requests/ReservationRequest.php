<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'first_name' => 'required|string|max:20',
            'last_name'=> 'required|string|max:20',
            'contact_number'=>'required|string|max:13',
            'pet_id'=>'required|integer',
            'date'=>'required|date',
            'time'=>'required',
        ];
    }
}

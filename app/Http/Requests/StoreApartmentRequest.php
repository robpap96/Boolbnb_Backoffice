<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'title' => 'required|string|max:150',
            'rooms_num' => 'required|numeric|between:1,15',
            'beds_num' => 'required|numeric|between:1,15',
            'baths_num' => 'required|numeric|between:1,15',
            'description' => 'required|string',
            'price' => 'required|decimal:2|between:1,10000',
            'mq' => 'required|numeric|between:1,15000',
            'image' => 'required|image|max:2048',
            'full_address' => 'required|string|max:255',
            'services' =>  'nullable|exists:services,id',
            'is_visible' => ''
        ];
    }
}

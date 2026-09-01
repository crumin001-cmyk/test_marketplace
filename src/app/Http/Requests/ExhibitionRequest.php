<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required', 'max:20'],
            'description' => ['required', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'condition_id' => ['required'],
            'categories' => ['required', 'array'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }


    public function attributes()
    {
        return [
            'name' => '商品名',
        ];
    }
}

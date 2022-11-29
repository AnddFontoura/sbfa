<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'userIsPlayer' => 'nullable|boolean',
            'userName' =>  'required|string|min:1|max:254',
            'userPhoto' => 'nullable|file|image',
            'userNickName' => 'nullable|string|min:1|max:254',
            'userWeight' => 'nullable|numeric',
            'userHeight' => 'nullable|numeric',
            'userBirthday' => 'nullable|date',
            'userDescription' => 'nullable|string|min:1|max:10000',
            'userPositions' => 'nullable|array'
        ];
    }
}

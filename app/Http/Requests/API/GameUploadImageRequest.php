<?php

namespace App\Http\Requests\API;

use InfyOm\Generator\Request\APIRequest;

class GameUploadImageRequest extends APIRequest
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
        $rules = [
            'type' => 'required',
            'image' =>  'required|file|mimes:jpeg,jpg,png,gif,svg,ico,webp',
        ];

        return $rules;
    }
}

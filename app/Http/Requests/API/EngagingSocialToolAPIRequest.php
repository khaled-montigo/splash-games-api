<?php

namespace App\Http\Requests\API;

use App\Models\EngagingSocialTool;
use InfyOm\Generator\Request\APIRequest;

class EngagingSocialToolAPIRequest extends APIRequest
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
            'icon' => 'required|file|mimes:jpeg,jpg,png,gif,svg,ico,webp'
        ];

        if(strtolower($this->query->get('_method')) === 'put'){
            $rules = [];
        }


        $Locals = config('translatable.locales');
        $LocalRequired = config('translatable.locales_required');
        foreach ($Locals as $Local){
            if(isset($LocalRequired[$Local])){
                if($LocalRequired[$Local]['require']){
                    $rules['engaging_social.'.$Local.'.title'] = 'required|string|max:255';
                    $rules['engaging_social.'.$Local.'.description'] = 'required|string|max:255';
                }
            }
        }

        return $rules;
    }
}

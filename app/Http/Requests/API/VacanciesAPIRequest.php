<?php

namespace App\Http\Requests\API;

use App\Models\Vacancies;
use InfyOm\Generator\Request\APIRequest;

class VacanciesAPIRequest extends APIRequest
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
            'experience_from' => 'required|integer',
            'experience_to' => 'required|integer',
            'expiry_on' => 'required|date'
        ];

        $Locals = config('translatable.locales');
        $LocalRequired = config('translatable.locales_required');
        foreach ($Locals as $Local){
            if(isset($LocalRequired[$Local])){
                if($LocalRequired[$Local]['require']){
                    $rules['description.'.$Local.'.title'] = 'required|string|max:255';
                    $rules['description.'.$Local.'.description'] = 'required|string';
                }
            }
        }
        return $rules;
    }
}

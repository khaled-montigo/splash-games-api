<?php

namespace App\Http\Requests\API;

use App\Models\Game;
use Illuminate\Validation\Rule;
use InfyOm\Generator\Request\APIRequest;

class GameAPIRequest extends APIRequest
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
            'url' => 'required|string|max:255|'.Rule::unique('games', 'url')->ignore($this->game),
            'image' =>  'required|file|mimes:jpeg,jpg,png,gif,svg,ico,webp',
            'logo' => 'required|file|mimes:jpeg,jpg,png,gif,svg,ico,webp',
            'devices_image' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg,ico,webp',
        ];


        $Locals = config('translatable.locales');
        $LocalRequired = config('translatable.locales_required');
        foreach ($Locals as $Local){
            if(isset($LocalRequired[$Local])){
               if($LocalRequired[$Local]['require']){
                   $rules['description.'.$Local.'.section'] = 'required|string|max:255';
                   $rules['description.'.$Local.'.name'] = 'required|string|max:255';
                   $rules['description.'.$Local.'.description'] = 'nullable|string';
                   $rules['description.'.$Local.'.game_type'] = 'nullable|string|max:255';
                   $rules['description.'.$Local.'.category'] = 'nullable|string|max:255';
                   $rules['description.'.$Local.'.devices'] = 'required|string|max:255';
                   $rules['description.'.$Local.'.tournaments'] = 'nullable|string|max:255';
                   $rules['description.'.$Local.'.additional'] = 'nullable|string|max:255';
                   $rules['description.'.$Local.'.engaging_social_description'] = 'nullable|string|max:255';
               }
            }
        }


        $input = $this->all();
        if(isset($input['TournamentsArea'])){
            $rules['TournamentsArea.'.'image'] = 'required|file|mimes:jpeg,jpg,png,gif,svg,ico,webp';
            $rules['TournamentsArea.'.'image_col'] =  'required|integer|max:12';
            foreach ($Locals as $Local){
                if(isset($LocalRequired[$Local])){
                    if($LocalRequired[$Local]['require']){
                        $rules['TournamentsArea.'.$Local.'.title'] = 'required|string|max:255';
                        $rules['TournamentsArea.'.$Local.'.description'] = 'required|string|max:255';
                    }
                }
            }
        }

        if(isset($input['SpinsArea'])){
            $rules['SpinsArea.'.'.image'] = 'required|file|mimes:jpeg,jpg,png,gif,svg,ico,webp';
            $rules['SpinsArea.'.'.image_col'] =  'required|integer|max:12';
            foreach ($Locals as $Local){
                if(isset($LocalRequired[$Local])){
                    if($LocalRequired[$Local]['require']){
                        $rules['SpinsArea.'.$Local.'.title'] = 'required|string|max:255';
                        $rules['SpinsArea.'.$Local.'.description'] = 'required|string|max:255';
                    }
                }
            }
        }

        return $rules;
    }

//    public function messages()
//    {
//        $rules = [];
//        $Locals = config('translatable.locales');
//        $LocalRequired = config('translatable.locales_required');
//        foreach ($Locals as $Local){
//            if(isset($LocalRequired[$Local])){
//                if($LocalRequired[$Local]['require']){
//                    $rules['description.'.$Local.'.*.required'] = 'required :attribute';
//
//                }
//            }
//        }
//        return $rules;
//    }




}

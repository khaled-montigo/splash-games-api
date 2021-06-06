<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;




/**
 * Class GameProperty
 * @package App\Models
 * @version May 24, 2021, 1:13 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $gameHasProperties
 * @property \Illuminate\Database\Eloquent\Collection $gamePropertyDescriptions
 * @property string $icon
 */
class GameProperty extends Model implements TranslatableContract
{
    use Translatable;
    public $translationModel = GamePropertyDescription::class;
    public $translatedAttributes = ['title', 'description'];


    public $table = 'game_properties';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'icon'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'icon' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'icon' => 'required|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gameHasProperties()
    {
        return $this->hasMany(\App\Models\GameHasProperty::class, 'game_property_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gamePropertyDescriptions()
    {
        return $this->hasMany(\App\Models\GamePropertyDescription::class, 'game_property_id');
    }
}

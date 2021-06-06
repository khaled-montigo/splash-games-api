<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


/**
 * Class promoTool
 * @package App\Models
 * @version May 24, 2021, 2:34 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $gameHasPromoTools
 * @property \Illuminate\Database\Eloquent\Collection $promoToolDescriptions
 * @property string $icon
 * @property integer $col
 * @property boolean $button
 */
class PromoTool extends Model implements TranslatableContract
{
    use Translatable;
    public $translationModel = PromoToolDescription::class;
    public $translatedAttributes = ['title', 'description'];

    public $table = 'promo_tools';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'icon',
        'col',
        'button'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'icon' => 'string',
        'col' => 'integer',
        'button' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'icon' => 'required|string|max:255',
        'col' => 'required|integer',
        'button' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gameHasPromoTools()
    {
        return $this->hasMany(\App\Models\GameHasPromoTool::class, 'promo_tool_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function promoToolDescriptions()
    {
        return $this->hasMany(\App\Models\PromoToolDescription::class, 'promo_tool_id');
    }
}

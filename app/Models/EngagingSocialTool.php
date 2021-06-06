<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;



/**
 * Class EngagingSocialTool
 * @package App\Models
 * @version May 25, 2021, 9:14 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $engagingSocialToolDescriptions
 * @property \Illuminate\Database\Eloquent\Collection $gameHasEngagingSocialTools
 * @property string $icon
 * @property string $image
 */
class EngagingSocialTool extends Model implements TranslatableContract
{

    use Translatable;
    public $translationModel = EngagingSocialToolDescription::class;
    public $translatedAttributes = ['title', 'description'];

    public $table = 'engaging_social_tools';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'icon',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'icon' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'icon' => 'required|string|max:255',
        'image' => 'required|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function engagingSocialToolDescriptions()
    {
        return $this->hasMany(\App\Models\EngagingSocialToolDescription::class, 'engaging_social_tool_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function gameHasEngagingSocialTools()
    {
        return $this->hasMany(\App\Models\GameHasEngagingSocialTool::class, 'engaging_social_tool_id');
    }
}

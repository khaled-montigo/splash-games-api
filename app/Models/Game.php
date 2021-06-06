<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Support\Facades\App;


/**
 * Class Game
 * @package App\Models
 * @version May 24, 2021, 7:20 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $gameDescriptions
 * @property string $url
 * @property integer $col
 * @property string $image
 * @property string $logo
 * @property string $devices_image
 */
class Game extends Model implements TranslatableContract
{
    use Translatable;
    public $translationModel = GameDescription::class;
    public $translatedAttributes = ['section','name', 'description', 'game_type', 'category', 'devices', 'tournaments', 'additional','engaging_social_description'];

    public $table = 'games';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'url',
        'col',
        'image',
        'logo',
        'devices_image',
        'image_list'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'url' => 'string',
        'col' => 'integer',
        'image' => 'string',
        'logo' => 'string',
        'devices_image' => 'string',
        'image_list' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'url' => 'required|string|max:255',
        'col' => 'required|integer',
        'image' => 'required|string|max:255',
        'logo' => 'required|string|max:255',
        'devices_image' => 'nullable|string|max:255'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/


    public function gameDescriptions()
    {
        return $this->hasMany(\App\Models\GameDescription::class, 'game_id', 'id');
    }

    public function Properties()
    {
        return $this->belongsToMany(\App\Models\GameProperty::class, 'game_has_properties', 'game_id', 'game_property_id');
    }
    public function PropertiesIDs()
    {
        return $this->belongsToMany(\App\Models\GameProperty::class, 'game_has_properties', 'game_id', 'game_property_id')->pluck('game_has_properties.game_property_id')->toArray();;
    }

    public function PromoTools()
    {
        return $this->belongsToMany(\App\Models\PromoTool::class, 'game_has_promo_tool', 'game_id', 'promo_tool_id');
    }

    public function PromoToolsIDs()
    {
        return $this->belongsToMany(\App\Models\GameProperty::class, 'game_has_promo_tool', 'game_id', 'promo_tool_id')->pluck('game_has_promo_tool.promo_tool_id')->toArray();;
    }

    public function EngagingAndSocial()
    {
        return $this->belongsToMany(\App\Models\EngagingSocialTool::class, 'game_has_engaging_social_tool', 'game_id', 'engaging_social_tool_id');
    }

    public function EngagingAndSocialIDs()
    {
        return $this->belongsToMany(\App\Models\GameProperty::class, 'game_has_engaging_social_tool', 'game_id', 'engaging_social_tool_id')->pluck('game_has_engaging_social_tool.engaging_social_tool_id')->toArray();;
    }

    public function TournamentsArea()
    {
        return $this->hasOne(\App\Models\TournamentsSpins::class, 'game_id')->where('type','tournaments');
    }

    public function SpinsArea()
    {
        return $this->hasOne(\App\Models\TournamentsSpins::class, 'game_id')->where('type','spins');
    }
}

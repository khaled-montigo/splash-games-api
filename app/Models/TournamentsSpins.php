<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class TournamentsSpins extends Model implements TranslatableContract
{
    use Translatable;
    public $translationModel = TournamentsSpinsDescription::class;
    public $translatedAttributes = ['title', 'description'];

    public $table = 'game_tournaments_spins';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'game_id',
        'type',
        'image',
        'image_col'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'game_id' => 'integer',
        'icon' => 'string',
        'image' => 'string',
        'image_col' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function Game()
    {
        return $this->belongsTo(\App\Models\GameHasPromoTool::class, 'game_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function tournamentsSpinsDescriptions()
    {
        return $this->hasMany(\App\Models\TournamentsSpinsDescription::class, 'tournaments_spins_id');
    }
}

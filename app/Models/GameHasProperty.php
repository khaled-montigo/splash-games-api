<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHasProperty extends Model
{
    use HasFactory;
    protected $table = 'game_has_properties';
    public $fillable = [
        'game_id',
        'game_property_id',
    ];

    public function Game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id');
    }

    public function gameProperty()
    {
        return $this->belongsTo(\App\Models\GameProperty::class, 'game_property_id');
    }
}

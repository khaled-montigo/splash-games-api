<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDescription extends Model
{
    use HasFactory;
    protected $table ='game_description';
    protected $fillable = ['name', 'description', 'game_type', 'category', 'devices', 'tournaments', 'additional','engaging_social_description'];
    public $timestamps = false;


    public function Game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id');
    }

}

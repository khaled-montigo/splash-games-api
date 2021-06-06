<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentsSpinsDescription extends Model
{
    use HasFactory;
    protected $table = "game_tournaments_spins_description";
    protected $fillable = ['title', 'description'];
    public $timestamps = false;


    public function TournamentsSpins()
    {
        return $this->belongsTo(\App\Models\PromoTool::class, 'tournaments_spins_id');
    }
}

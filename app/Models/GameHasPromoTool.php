<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHasPromoTool extends Model
{
    use HasFactory;
    protected $table = 'game_has_promo_tool';
    public $fillable = [
        'game_id',
        'promo_tool_id',
    ];

    public function Game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id');
    }

    public function PromoTool()
    {
        return $this->belongsTo(\App\Models\PromoTool::class, 'promo_tool_id');
    }
}

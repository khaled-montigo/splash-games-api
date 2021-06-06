<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHasEngagingSocialTool extends Model
{
    use HasFactory;
    protected $table = 'game_has_engaging_social_tool';
    public $fillable = [
        'game_id',
        'engaging_social_tool_id',
    ];

    public function Game()
    {
        return $this->belongsTo(\App\Models\Game::class, 'game_id');
    }

    public function EngagingSocialTool()
    {
        return $this->belongsTo(\App\Models\EngagingSocialTool::class, 'engaging_social_tool_id');
    }
}

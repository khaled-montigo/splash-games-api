<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePropertyDescription extends Model
{
    use HasFactory;
    protected $table ='game_property_description';
    protected $fillable = ['title', 'description'];
    public $timestamps = false;


    public function gameProperty()
    {
        return $this->belongsTo(\App\Models\GameProperty::class, 'game_property_id');
    }
}

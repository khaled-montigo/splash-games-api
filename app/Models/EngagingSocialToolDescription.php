<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagingSocialToolDescription extends Model
{
    use HasFactory;
    protected $table ='engaging_social_tool_description';
    protected $fillable = ['title', 'description'];
    public $timestamps = false;


    public function EngagingSocial()
    {
        return $this->belongsTo(\App\Models\EngagingSocialTool::class, 'engaging_social_tool_id');
    }
}

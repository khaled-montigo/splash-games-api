<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoToolDescription extends Model
{
    use HasFactory;
    protected $table ='promo_tool_description';
    protected $fillable = ['title', 'description'];
    public $timestamps = false;


    public function PromoTool()
    {
        return $this->belongsTo(\App\Models\PromoTool::class, 'promo_tool_id');
    }
}

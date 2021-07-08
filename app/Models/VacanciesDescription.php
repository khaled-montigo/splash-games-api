<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacanciesDescription extends Model
{
    use HasFactory;
    protected $table = "vacancies_description";
    protected $fillable = ['title', 'description'];
    public $timestamps = false;


    public function Vacancies()
    {
        return $this->belongsTo(\App\Models\Vacancies::class, 'vacancy_id');
    }
}

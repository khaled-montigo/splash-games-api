<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Vacancies
 * @package App\Models
 * @version July 7, 2021, 1:17 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $vacanciesDescriptions
 * @property integer $experience_from
 * @property integer $experience_to
 * @property string $expiry_on
 */
class Vacancies extends Model implements TranslatableContract
{
    use Translatable;
    public $translationModel = VacanciesDescription::class;
    public $translationForeignKey = "vacancy_id";
    public $translatedAttributes = ['title', 'description'];

    public $table = 'vacancies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'experience_from',
        'experience_to',
        'expiry_on'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'experience_from' => 'integer',
        'experience_to' => 'integer',
        'expiry_on' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'experience_from' => 'required|integer',
        'experience_to' => 'required|integer',
        'expiry_on' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function vacanciesDescriptions()
    {
        return $this->hasMany(\App\Models\VacanciesDescription::class, 'vacancy_id');
    }
}

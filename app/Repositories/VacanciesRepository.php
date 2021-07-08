<?php

namespace App\Repositories;

use App\Models\Vacancies;
use App\Repositories\BaseRepository;

/**
 * Class VacanciesRepository
 * @package App\Repositories
 * @version July 7, 2021, 1:17 pm UTC
*/

class VacanciesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'experience_from',
        'experience_to',
        'expiry_on'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Vacancies::class;
    }
}

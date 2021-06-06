<?php

namespace App\Repositories;

use App\Models\GameProperty;
use App\Repositories\BaseRepository;

/**
 * Class GamePropertyRepository
 * @package App\Repositories
 * @version May 24, 2021, 1:13 pm UTC
*/

class GamePropertyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'icon'
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
        return GameProperty::class;
    }
}

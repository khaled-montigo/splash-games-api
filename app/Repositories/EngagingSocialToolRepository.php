<?php

namespace App\Repositories;

use App\Models\EngagingSocialTool;
use App\Repositories\BaseRepository;

/**
 * Class EngagingSocialToolRepository
 * @package App\Repositories
 * @version May 25, 2021, 9:14 am UTC
*/

class EngagingSocialToolRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'icon',
        'image'
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
        return EngagingSocialTool::class;
    }
}

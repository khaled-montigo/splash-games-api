<?php

namespace App\Repositories;

use App\Models\PromoTool;
use App\Repositories\BaseRepository;

/**
 * Class promoToolRepository
 * @package App\Repositories
 * @version May 24, 2021, 2:34 pm UTC
*/

class promoToolRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'icon',
        'col',
        'button'
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
        return PromoTool::class;
    }
}

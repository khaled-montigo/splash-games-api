<?php

namespace App\Repositories;

use App\Models\Game;
use App\Repositories\BaseRepository;

/**
 * Class GameRepository
 * @package App\Repositories
 * @version May 24, 2021, 7:20 am UTC
*/

class GameRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'url',
        'col',
        'image',
        'logo',
        'devices_image'
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
        return Game::class;
    }
}

<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Tool;
use App\Repositories\BaseRepository;

/**
 * Class ToolRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 8:05 am WIB
*/

class ToolRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'description'
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
        return Tool::class;
    }
}

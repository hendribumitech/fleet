<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Category;
use App\Repositories\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories\Fleet
 * @version March 13, 2023, 2:48 pm WIB
*/

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name'
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
        return Category::class;
    }
}

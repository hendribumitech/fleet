<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\ChecklistItem;
use App\Repositories\BaseRepository;

/**
 * Class ChecklistItemRepository
 * @package App\Repositories\Fleet
 * @version May 13, 2023, 8:43 am WIB
*/

class ChecklistItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'code'
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
        return ChecklistItem::class;
    }
}

<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Sparepart;
use App\Repositories\BaseRepository;

/**
 * Class SparepartRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 8:05 am WIB
*/

class SparepartRepository extends BaseRepository
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
        return Sparepart::class;
    }
}

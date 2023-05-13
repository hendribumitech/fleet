<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\VehicleOdoometer;
use App\Repositories\BaseRepository;

/**
 * Class VehicleOdoometerRepository
 * @package App\Repositories\Fleet
 * @version May 13, 2023, 8:43 am WIB
*/

class VehicleOdoometerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'vehicle_id',
        'odoometer'
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
        return VehicleOdoometer::class;
    }
}

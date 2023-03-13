<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Vehicle;
use App\Repositories\BaseRepository;

/**
 * Class VehicleRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 8:05 am WIB
*/

class VehicleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'registration_number',
        'name',
        'merk',
        'engine_number',
        'identity_number',
        'owner_name',
        'registration_year',
        'purchase_date',
        'vehicle_ownership_number'
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
        return Vehicle::class;
    }
}

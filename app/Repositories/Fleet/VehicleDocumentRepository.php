<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\VehicleDocument;
use App\Repositories\BaseRepository;

/**
 * Class VehicleDocumentRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 12:47 pm WIB
*/

class VehicleDocumentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'number',
        'document_id',
        'vehicle_id',
        'path_file',
        'issued_at',
        'expired_at'
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
        return VehicleDocument::class;
    }
}

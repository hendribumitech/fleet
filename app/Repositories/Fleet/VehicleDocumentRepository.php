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

    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $input['active'] = $input['active'] ?? 1;
            $model = $this->model->newInstance($input);
            $model->save();            
            $this->setNonActiveOlderDocument($model);
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }   
    }    

    private function setNonActiveOlderDocument($model){        
        VehicleDocument::where(['document_id' => $model->document_id, 'vehicle_id' => $model->vehicle_id, 'active' => 1])
            ->where('id', '<>', $model->id)->where('expired_at', '<=', $model->getRawOriginal('expired_at'))
            ->update(['active' => 0]);
    }
}

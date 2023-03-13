<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Maintenance;
use App\Repositories\BaseRepository;

/**
 * Class MaintenanceRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 8:05 am WIB
*/

class MaintenanceRepository extends BaseRepository
{    
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'vehicle_id',
        'start',
        'end',
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
        return Maintenance::class;
    }

    public function update($input, $id)
    {        
        $this->model->getConnection()->beginTransaction();
        try {
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            if($input['end']){
                $input['status'] = 'Complete';
            }
            $model->fill($input);
            $services = $input['services'];
            
            $spareparts = $input['spareparts'];            
            $model->save();
            $this->saveServices($model, $services);
            $this->saveSpareparts($model, $spareparts);

            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    private function saveServices($model, $services){
        $this->removePreviousServices($model);
        if($services){     
            $filterServices = [];            
            foreach($services as $service){                
                if($service['description']){
                    $filterServices[] = $service;
                }
            }
                        
            $model->maintenanceServices()->createMany($filterServices);
        }
    }
    private function saveSpareparts($model, $spareparts){
        $this->removePreviousSpareparts($model);
        if($spareparts){
            $filterSpareparts = [];
            foreach($spareparts as $sparepart){
                if(isset($sparepart['sparepart_id'])){
                    if($sparepart['sparepart_id']){
                        $filterSpareparts[] = $sparepart;
                    }                    
                }
            }
            $model->maintenanceSpareparts()->createMany($filterSpareparts);
        }
    }

    private function removePreviousServices($model){
        $model->maintenanceServices()->delete();
    }

    private function removePreviousSpareparts($model){
        $model->maintenanceSpareparts()->delete();
    }
}

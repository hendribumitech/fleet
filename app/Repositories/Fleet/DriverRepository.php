<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Driver;
use App\Models\Fleet\VehicleDriver;
use App\Repositories\BaseRepository;

/**
 * Class DriverRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 8:05 am WIB
*/

class DriverRepository extends BaseRepository
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
        return Driver::class;
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
            $model = $this->model->newInstance($input);
            $model->save();
            $vehicle = $input['vehicle_id'];
            if($vehicle){
                $this->insertDriverVehicle($model);
            }            
            (new VehicleDriver)->flushCache();
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    /**
     * Update model record for given id.
     *
     * @param array $input
     * @param int   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $oldModel = clone $model;
            $model->fill($input);
            $model->save();            
            
            if($oldModel->vehicle_id != $model->vehicle_id){
                $this->removeVehicleDrivers($model);
                if($model->vehicle_id){
                    $this->insertDriverVehicle($model);
                }
            }
            (new VehicleDriver)->flushCache();
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }    

    private function removeVehicleDrivers($model){
        $model->vehicleDrivers()->delete();
    }

    private function insertDriverVehicle($model){
        $model->vehicleDrivers()->create(['vehicle_id' => $model->vehicle_id]);
    }
}

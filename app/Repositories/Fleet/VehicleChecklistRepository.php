<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\VehicleChecklist;
use App\Models\Fleet\VehicleChecklistItem;
use App\Repositories\BaseRepository;

/**
 * Class VehicleChecklistRepository
 * @package App\Repositories\Fleet
 * @version May 13, 2023, 8:44 am WIB
*/

class VehicleChecklistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'vehicle_id',
        'checklist_date'
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
        return VehicleChecklist::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $checklist = collect($input['checklist']);
            $model = $this->model->newInstance($input);
            $model->save();            
                        
            $model->vehicleChecklistItems()->saveMany(
                $checklist->map(function($item, $key){
                    $item['checklist_item_id'] = $key;
                    return new VehicleChecklistItem($item);
                })
            );

            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }   
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $checklist = $input['checklist'];
            $model = parent::update($input, $id);            
            foreach($checklist as $key => &$check){
                $check['checklist_item_id'] = $key;
                $check['vehicle_checklist_id'] = $id;
            }
            $model->vehicleChecklistItems()->upsert(
                $checklist, ['checklist_item_id', 'vehicle_checklist_id']
            );
            
            $this->model->getConnection()->commit();
            (new VehicleChecklistItem())->flushCache();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }   
    }
}

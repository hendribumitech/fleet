<?php

namespace App\Http\Requests\Fleet;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Fleet\Maintenance;

class CreateMaintenanceRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permissionName = 'maintenances-create';
        return Auth::user()->can($permissionName);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Maintenance::$rules;
        $vehicleId = $this->get('vehicle_id');
        if($vehicleId){
            $lastMaintenance = Maintenance::select(['odometer'])->whereVehicleId($vehicleId)->orderBy('id','desc')->first();
            if($lastMaintenance){
                $odometer = $rules['odometer'];
                $rules['odometer'] = $odometer.'|min:'.$lastMaintenance->odometer;
            }            
        }
        
        return $rules;
    }

    /**
     * Get all of the input based value from property fillable  in model and files for the request.
     *
     * @param null|array|mixed $keys
     *
     * @return array
    */
    public function all($keys = null){
        $keys = (new Maintenance)->fillable;
        return parent::all($keys);
    }
}

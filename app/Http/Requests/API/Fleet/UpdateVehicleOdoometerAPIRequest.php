<?php

namespace App\Http\Requests\API\Fleet;

use App\Models\Fleet\VehicleOdoometer;
use InfyOm\Generator\Request\APIRequest;

class UpdateVehicleOdoometerAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = VehicleOdoometer::$rules;
        
        return $rules;
    }
}

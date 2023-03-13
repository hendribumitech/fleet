<?php

namespace App\Http\Requests\API\Fleet;

use App\Models\Fleet\Maintenance;
use InfyOm\Generator\Request\APIRequest;

class CreateMaintenanceAPIRequest extends APIRequest
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
        return Maintenance::$rules;
    }
}

<?php

namespace App\Http\Requests\Fleet;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Fleet\VehicleDocument;

class UpdateVehicleDocumentRequest extends FormRequest
{
    private $excludeKeys = ['vehicle_id']; 

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $permissionName = 'vehicle_documents-update';
        return Auth::user()->can($permissionName);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = VehicleDocument::$rules;
        
        $rules = $this->excludeKeys ? array_diff_key($rules, array_combine($this->excludeKeys, $this->excludeKeys)) : $rules;
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
        $keys = (new VehicleDocument)->fillable;
        $keys = $this->excludeKeys ? array_diff($keys, $this->excludeKeys) : $keys;
        return parent::all($keys);
    }
}

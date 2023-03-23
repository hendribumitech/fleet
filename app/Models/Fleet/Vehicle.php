<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Vehicle",
 *      required={"engine_number", "identity_number", "registration_year"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="isi dengan  nik sopir",
 *          type="string"
 *      )
 * )
 */
class Vehicle extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'vehicles';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'registration_number',
        'name',
        'merk',
        'engine_number',
        'identity_number',
        'owner_name',
        'registration_year',
        'purchase_date',
        'vehicle_ownership_number',
        'cilinder_capacity'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'registration_number' => 'string',
        'name' => 'string',
        'merk' => 'string',
        'engine_number' => 'string',
        'identity_number' => 'string',
        'owner_name' => 'string',
        'registration_year' => 'string',
        'purchase_date' => 'date',
        'vehicle_ownership_number' => 'string',
        'cilinder_capacity' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'registration_number' => 'nullable|string|max:20',
        'name' => 'nullable|string|max:50',
        'merk' => 'nullable|string|max:30',
        'engine_number' => 'required|string|max:50',
        'identity_number' => 'required|string|max:50',
        'owner_name' => 'nullable|string|max:255',
        'registration_year' => 'required|string|max:4',
        'purchase_date' => 'nullable',
        'vehicle_ownership_number' => 'nullable|string|max:50',
        'cilinder_capacity' => 'required|numeric|max:90000'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function maintenances()
    {
        return $this->hasMany(\App\Models\Fleet\Maintenance::class, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function vehicleDrivers()
    {
        return $this->hasMany(\App\Models\Fleet\VehicleDriver::class, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function vehicleTools()
    {
        return $this->hasMany(\App\Models\Fleet\VehicleTool::class, 'vehicle_id');
    }

    protected function getPurchaseDateAttribute($value){
        return localFormatDate($value);
    }

    protected function getCilinderCapacityAttribute($value){
        return localNumberFormat($value, 0);
    }
}

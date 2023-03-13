<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Driver",
 *      required={"name", "code"},
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
class Driver extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'drivers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'code',
        'vehicle_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'vehicle_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:20'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function vehicleDrivers()
    {
        return $this->hasMany(\App\Models\Fleet\VehicleDriver::class, 'driver_id');
    }

    /**
     * Get the vehicle associated with th
     *
     * @return \Illuminate\Database\EloquVehicleRelations\vehicle_id */
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id' ,'vehicle_id');
    }
}

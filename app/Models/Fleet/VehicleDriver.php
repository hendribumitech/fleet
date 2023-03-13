<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="VehicleDrivers",
 *      required={"driver_id", "vehicle_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="driver_id",
 *          description="driver_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="vehicle_id",
 *          description="vehicle_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class VehicleDriver extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'vehicle_drivers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'driver_id',
        'vehicle_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'driver_id' => 'integer',
        'vehicle_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'driver_id' => 'required',
        'vehicle_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function driver()
    {
        return $this->belongsTo(\App\Models\Fleet\Driver::class, 'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Fleet\Vehicle::class, 'vehicle_id');
    }
}

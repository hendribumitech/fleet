<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Maintenance",
 *      required={"vehicle_id", "start"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="vehicle_id",
 *          description="vehicle_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="start",
 *          description="start",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="end",
 *          description="end",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class Maintenance extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'maintenances';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'vehicle_id',
        'start',
        'end',
        'description',
        'status',
        'categories_id',
        'odometer'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'vehicle_id' => 'integer',
        'start' => 'datetime',
        'end' => 'datetime',
        'description' => 'string',
        'status' => 'string',
        'odometer' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'vehicle_id' => 'required',
        'start' => 'required',
        'odometer' => 'required|numeric',
        'end' => 'nullable',
        'description' => 'nullable|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Fleet\Vehicle::class, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function categories()
    {
        return $this->hasOne(\App\Models\Fleet\Category::class, 'id', 'categories_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function maintenanceServices()
    {
        return $this->hasMany(\App\Models\Fleet\MaintenanceService::class, 'maintenance_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function maintenanceSpareparts()
    {
        return $this->hasMany(\App\Models\Fleet\MaintenanceSparepart::class, 'maintenance_id')->with(['sparepart']);
    }

    protected function getStartAttribute($value){
        return localFormatDateTime($value);
    }

    protected function getEndAttribute($value){
        return localFormatDateTime($value);
    }
}

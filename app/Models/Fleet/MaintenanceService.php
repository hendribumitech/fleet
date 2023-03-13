<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="MaintenanceService",
 *      required={"maintenance_id", "description"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="maintenance_id",
 *          description="maintenance_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class MaintenanceService extends Model
{
    use HasFactory;        

    public $table = 'maintenance_services';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const CREATED_BY = NULL;
    const UPDATED_BY = NULL;
    protected $dates = ['deleted_at'];



    public $fillable = [
        'maintenance_id',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'maintenance_id' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'maintenance_id' => 'required',
        'description' => 'required|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function maintenance()
    {
        return $this->belongsTo(\App\Models\Fleet\Maintenance::class, 'maintenance_id');
    }
}

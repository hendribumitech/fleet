<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="MaintenanceSparepart",
 *      required={"maintenance_id", "sparepart_id"},
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
 *          property="sparepart_id",
 *          description="sparepart_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="quantity",
 *          description="quantity",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class MaintenanceSparepart extends Model
{
    use HasFactory;        

    public $table = 'maintenance_spareparts';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const CREATED_BY = NULL;
    const UPDATED_BY = NULL;


    protected $dates = ['deleted_at'];



    public $fillable = [
        'maintenance_id',
        'sparepart_id',
        'quantity'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'maintenance_id' => 'integer',
        'sparepart_id' => 'integer',
        'quantity' => 'decimal:2'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'maintenance_id' => 'required',
        'sparepart_id' => 'required',
        'quantity' => 'nullable|decimal'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function maintenance()
    {
        return $this->belongsTo(\App\Models\Fleet\Maintenance::class, 'maintenance_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sparepart()
    {
        return $this->belongsTo(\App\Models\Fleet\Sparepart::class, 'sparepart_id');
    }

    protected function getQuantityAttribute($value){
        return localNumberFormat($value, 1);
    }
}

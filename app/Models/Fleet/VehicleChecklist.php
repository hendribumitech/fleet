<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="VehicleChecklist",
 *      required={"vehicle_id", "checklist_date"},
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
 *          property="checklist_date",
 *          description="checklist_date",
 *          type="string",
 *          format="date"
 *      )
 * )
 */
class VehicleChecklist extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'vehicle_checklists';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'vehicle_id',
        'checklist_date',
        'summary'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'vehicle_id' => 'integer',
        'checklist_date' => 'date',
        'summary' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'vehicle_id' => 'required',
        'checklist_date' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Fleet\Vehicle::class, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function vehicleChecklistItems()
    {
        return $this->hasMany(\App\Models\Fleet\VehicleChecklistItem::class, 'vehicle_checklist_id');
    }

    protected function getChecklistDateAttribute($value){
        return localFormatDate($value);
    }
}

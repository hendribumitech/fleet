<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="VehicleChecklistItems",
 *      required={"vehicle_checklist_id", "checklist_item_id", "status"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="vehicle_checklist_id",
 *          description="vehicle_checklist_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="checklist_item_id",
 *          description="checklist_item_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class VehicleChecklistItem extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'vehicle_checklist_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'vehicle_checklist_id',
        'checklist_item_id',
        'status',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'vehicle_checklist_id' => 'integer',
        'checklist_item_id' => 'integer',
        'status' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'vehicle_checklist_id' => 'required',
        'checklist_item_id' => 'required',
        'status' => 'required|string',
        'description' => 'nullable|string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function checklistItem()
    {
        return $this->belongsTo(\App\Models\Fleet\ChecklistItem::class, 'checklist_item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function vehicleChecklist()
    {
        return $this->belongsTo(\App\Models\Fleet\VehicleChecklist::class, 'vehicle_checklist_id');
    }
}

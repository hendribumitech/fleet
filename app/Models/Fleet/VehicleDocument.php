<?php

namespace App\Models\Fleet;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="VehicleDocument",
 *      required={"name", "document_id", "vehicle_id"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      )
 * )
 */
class VehicleDocument extends Model
{
    use HasFactory;
        use SoftDeletes;

    public $table = 'vehicle_documents';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'number',
        'document_id',
        'vehicle_id',
        'path_file',
        'issued_at',
        'expired_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'number' => 'string',
        'document_id' => 'integer',
        'vehicle_id' => 'integer',
        'path_file' => 'string',
        'issued_at' => 'date',
        'expired_at' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:50',
        'number' => 'nullable|string|max:50',
        'document_id' => 'required',
        'vehicle_id' => 'required',
        'path_file' => 'nullable|string',
        'issued_at' => 'nullable',
        'expired_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function document()
    {
        return $this->belongsTo(\App\Models\Fleet\Document::class, 'document_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Fleet\Vehicle::class, 'vehicle_id');
    }

    protected function getIssuedAtAttribute($value){
        return localFormatDate($value);
    }

    protected function getExpiredAtAttribute($value){
        return localFormatDate($value);
    }
}

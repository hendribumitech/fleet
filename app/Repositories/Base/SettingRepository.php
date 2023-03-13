<?php

namespace App\Repositories\Base;

use App\Models\Base\Setting;
use App\Repositories\BaseRepository;

/**
 * Class SettingRepository
 * @package App\Repositories\Base
 * @version March 13, 2023, 2:10 pm WIB
*/

class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'value'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
    }
}

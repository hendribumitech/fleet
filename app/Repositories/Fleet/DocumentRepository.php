<?php

namespace App\Repositories\Fleet;

use App\Models\Fleet\Document;
use App\Repositories\BaseRepository;

/**
 * Class DocumentRepository
 * @package App\Repositories\Fleet
 * @version March 11, 2023, 12:47 pm WIB
*/

class DocumentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'description'
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
        return Document::class;
    }
}

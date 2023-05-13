<?php

namespace App\Http\Requests\API\Fleet;

use App\Models\Fleet\ChecklistItem;
use InfyOm\Generator\Request\APIRequest;

class CreateChecklistItemAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ChecklistItem::$rules;
    }
}

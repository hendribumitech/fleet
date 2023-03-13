<?php

namespace App\Http\Resources\Fleet;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'registration_number' => $this->registration_number,
            'name' => $this->name,
            'merk' => $this->merk,
            'engine_number' => $this->engine_number,
            'identity_number' => $this->identity_number,
            'owner_name' => $this->owner_name,
            'registration_year' => $this->registration_year,
            'purchase_date' => $this->purchase_date,
            'vehicle_ownership_number' => $this->vehicle_ownership_number
        ];
    }
}

<?php

namespace App\Http\Resources\Fleet;

use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceResource extends JsonResource
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
            'vehicle_id' => $this->vehicle_id,
            'start' => $this->start,
            'end' => $this->end,
            'description' => $this->description
        ];
    }
}

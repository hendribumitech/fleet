<?php

namespace App\Http\Resources\Fleet;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleDocumentResource extends JsonResource
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
            'name' => $this->name,
            'number' => $this->number,
            'document_id' => $this->document_id,
            'vehicle_id' => $this->vehicle_id,
            'path_file' => $this->path_file,
            'issued_at' => $this->issued_at,
            'expired_at' => $this->expired_at
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = 'Peatonal';
        
        if (isset($this->vehicle_details)) {
            $type = 'Vehículo';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $type,
            'visit_date' => $this->visit_date?->isoFormat('DD MMMM YYYY'),
            'time' => $this->time,
            'identification' => $this->identification,
            'arrived_at' => $this->arrived_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'leaved_at' => $this->leaved_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'notes' => $this->notes,
            'qr_code' => $this->qr_code,
            'vehicle_details' => $this->vehicle_details,
            'user' => $this->whenLoaded('user'),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

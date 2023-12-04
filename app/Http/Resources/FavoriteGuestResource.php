<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteGuestResource extends JsonResource
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
            'vehicle_details' => $this->vehicle_details,
            'identification' => $this->identification,
            'notes' => $this->notes,
            'user' => $this->whenLoaded('user'),
            'media_guest' => $this->getMedia('guest_images')->all(),
            'media_vehicle' => $this->getMedia('vehicle_images')->all(),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

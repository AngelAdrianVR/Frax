<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date?->isoFormat('MMM - DD'),
            'time' => $this->time?->isoFormat('h:mm A'),
            'participants' => $this->participants,
            'description' => $this->description,
            'place' => $this->place,
            'cost' => $this->cost,
            'rules' => $this->rules,
            'image_cover' => $this->getMedia('imageCover')->all(),
            'frax' => $this->whenLoaded('frax'),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

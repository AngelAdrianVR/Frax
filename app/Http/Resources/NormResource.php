<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NormResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'image_cover' => $this->getMedia('imageCover')->all(),
            'frax' => $this->whenLoaded('frax'),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

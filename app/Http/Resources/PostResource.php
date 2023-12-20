<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'body' => $this->body,
            'views' => $this->views,
            'likes' => $this->likes,
            'media' => $this->getMedia()->all(),
            'user' => $this->whenLoaded('user'),
            'frax' => $this->whenLoaded('frax'),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

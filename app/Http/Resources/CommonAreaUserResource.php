<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommonAreaUserResource extends JsonResource
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
            'date' => $this->date->toDateString(),
            'time' => $this->time->isoFormat('hh:mm'),
            'people_quantity' => $this->people_quantity,
            'qr_code' => $this->qr_code,
            'payment_data' => $this->payment_data,
            'cancelation_data' => $this->cancelation_data,
            'user' => $this->whenLoaded('user'),
            'common_area' => $this->whenLoaded('commonArea'),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = 'Pendiente';
        if ($this->arrived_at !== null) {
            $status = 'Ingresado';
        } else if ($this->arrived_at == null && $this->date < now()) {
            $status = 'Expirado';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type_access' => $this->type_access,
            'date' => $this->date?->isoFormat('DD MMMM YYYY'),
            'time' => $this->time?->isoFormat('h:mm A'),
            'arrived_at' => $this->arrived_at?->isoFormat('h:mm A'),
            'leaved_at' => $this->leaved_at?->isoFormat('h:mm A'),
            'notes' => $this->notes,
            'qr_code' => $this->qr_code,
            'status' => $status,
            'user' => $this->whenLoaded('user'),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

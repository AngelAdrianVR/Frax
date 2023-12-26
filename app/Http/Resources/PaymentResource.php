<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Convertir el array de facturas en una colección para facilitar la manipulación
        $billsCollection = collect($this->bills);

        // Calcular el total sumando todos los amounts
        $total = $billsCollection->sum('amount');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'limit_date' => $this->limit_date?->isoFormat('DD MMMM YYYY'),
            'is_expired' => optional($this->limit_date)->isPast(),
            'paid_at' => $this->paid_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'bills' => $this->bills,
            'total' => $total,
            'user' => $this->whenLoaded('user'),
            'frax' => $this->whenLoaded('frax'),
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->is_acredited === null) {
            $status = 'Esperando aprobación';
        } else if ($this->is_acredited == true) {
            $status = 'Pagado';
        } else {
            $status = 'Pago rechazado';
        } 
        

        return [
            'id' => $this->id,
            'acredited_at' => $this->acredited_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'is_acredited' => $this->is_acredited,
            'payment_method' => $this->payment_method,
            'payment' => PaymentResource::make($this->whenLoaded('payment')),
            'status' => $status,
            // 'type' => optional(optional($this->payment)->limit_date)->isPast() ? 'En tiempo' : 'Atrasado', //no lo vi conveniente,informacion irrelevante.
            'created_at' => $this->created_at?->isoFormat('DD MMMM YYYY, h:mm A'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMMM YYYY, h:mm A'),
        ];
    }
}

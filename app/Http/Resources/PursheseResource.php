<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PursheseResource extends JsonResource
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
            'client_email' => $this->client_email,
            'plant_name' => $this->plant_name,
            'freight_state' => $this->freight_state,
            'status' => $this->status,
            'mount' => $this->mount,
            'value' => $this->value,
        ];
    }
}

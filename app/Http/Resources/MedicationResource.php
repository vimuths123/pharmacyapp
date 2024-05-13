<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicationResource extends JsonResource
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
            'description' => $this->description,
            'quantity' => $this->quantity,
            'creator' => $this->whenLoaded('creator', fn () => new UserResource($this->creator)),
            'deleted_at' => $this->deleted_at, 
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

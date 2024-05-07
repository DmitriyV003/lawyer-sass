<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'telegram' => $this->telegram,
            'whats_app' => $this->whats_app,
            'phone' => $this->phone,
            'email' => $this->email,
            'last_active_at' => $this->last_active_at,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'lawsuits' => LawsuitResource::collection($this->whenLoaded('lawsuits')),
        ];
    }
}

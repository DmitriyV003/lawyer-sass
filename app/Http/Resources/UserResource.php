<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'lastname' => $this->resource->lastname,
            'surname' => $this->resource->surname,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'type' => $this->resource->type,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->resource->roles->pluck('name');
            })
        ];
    }
}

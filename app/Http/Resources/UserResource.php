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
            'start_working_time' => $this->resource->start_working_time,
            'end_working_time' => $this->resource->end_working_time,
            'working_time_interval' => $this->resource->working_time_interval,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->resource->roles->pluck('name');
            }),
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->resource->roles->pluck('name');
            }),
        ];
    }
}

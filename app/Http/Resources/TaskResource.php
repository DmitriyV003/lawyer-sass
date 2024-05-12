<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Task */
class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'theme' => $this->theme,
            'is_important' => $this->is_important,
            'status' => $this->status,
            'deadline' => $this->deadline,
            'to_do_date' => $this->to_do_date,
            'cost' => $this->cost,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'lawsuit' => new LawsuitResource($this->whenLoaded('lawsuit')),
            'taskTag' => new TaskTagResource($this->whenLoaded('taskTag')),
        ];
    }
}

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'theme' => $this->theme,
            'is_important' => $this->is_important,
            'deadline' => $this->deadline,
            'cost' => $this->cost,
            'comment' => $this->comment,

            'customer_id' => $this->customer_id,
            'lawsuit_id' => $this->lawsuit_id,
            'task_tag_id' => $this->task_tag_id,
            'user_id' => $this->user_id,

            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'lawsuit' => new LawsuitResource($this->whenLoaded('lawsuit')),
            'taskTag' => new TaskTagResource($this->whenLoaded('taskTag')),
        ];
    }
}

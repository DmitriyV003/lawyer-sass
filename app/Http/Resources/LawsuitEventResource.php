<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\LawsuitEvent */
class LawsuitEventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'theme' => $this->theme,
            'is_important' => $this->is_important,
            'since' => $this->since,
            'till' => $this->till,
            'cost' => $this->cost,
            'place' => $this->place,
            'comment' => $this->comment,
            'remain_days' => $this->remain_days,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'lawsuit_event_category' => new LawsuitEventCategoryResource($this->whenLoaded('lawsuitEventCategory')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'lawsuit' => new LawsuitResource($this->whenLoaded('lawsuit')),
            'task' => new TaskResource($this->whenLoaded('task')),
        ];
    }
}

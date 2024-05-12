<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Authority */
class AuthorityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lawsuit_number' => $this->lawsuit_number,
            'lawsuit_number_link' => $this->lawsuit_number_link,
            'authority' => $this->authority,
            'judge' => $this->judge,
            'cabinet' => $this->cabinet,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'lawsuit' => new LawsuitResource($this->whenLoaded('lawsuit')),
        ];
    }
}

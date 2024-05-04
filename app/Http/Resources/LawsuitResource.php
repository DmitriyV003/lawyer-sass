<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Lawsuit */
class LawsuitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plot' => $this->plot,
            'opponent' => $this->opponent,
            'rating' => $this->rating,
            'contract_number' => $this->contract_number,
            'contract_signing_date' => $this->contract_signing_date,
            'contract_validity' => $this->contract_validity,
            'power_of_attorney' => $this->power_of_attorney,
            'power_of_attorney_signing_date' => $this->power_of_attorney_signing_date,
            'power_of_attorney_validity' => $this->power_of_attorney_validity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'caseCategory' => new CaseCategoryResource($this->whenLoaded('caseCategory')),
        ];
    }
}

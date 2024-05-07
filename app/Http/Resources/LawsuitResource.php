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
            'contract_end_months' => $this->contract_end_months,
            'contract_end_days' => $this->contract_end_days,
            'power_of_attorney_end_months' => $this->power_of_attorney_end_months,
            'power_of_attorney_end_days' => $this->power_of_attorney_end_days,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'lawsuit_category' => new LawsuitCategoryResource($this->whenLoaded('lawsuitCategory')),
            'authorities' => AuthorityResource::collection($this->whenLoaded('authorities')),
            'authorities_count' => $this->whenCounted('authorities'),
        ];
    }
}

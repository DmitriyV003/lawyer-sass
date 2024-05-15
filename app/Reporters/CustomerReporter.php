<?php

namespace App\Reporters;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerReporter
{
    private ?User $user = null;
    private bool $contractValidityDateSortAsc = false;

    public function builder()
    {
        return Customer::query()
            ->select('customers.*')
            ->when($this->user, function ($query, $user) {
                $query->where('customers.user_id', $user->id);
            })
            ->when($this->contractValidityDateSortAsc, function ($query) {
                $latestLawsuits = DB::table('lawsuits')
                    ->whereColumn('customer_id', 'customers.id')
                    ->orderBy('contract_validity')
                    ->limit(1);
                $query->joinLateral($latestLawsuits, 'latest_lawsuit', 'left')
                    ->orderByRaw('latest_lawsuit.contract_validity asc NULLS LAST');
            });
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function contractValidityDateSortAsc(): self
    {
        $this->contractValidityDateSortAsc = true;

        return $this;
    }
}

<?php

namespace App\Services;

use App\Models\CaseCategory;
use App\Models\User;

class CaseCategoryService
{
    public function create(array $params, User $user): CaseCategory
    {
        $category = app(CaseCategory::class)->fill($params);
        $category->user()->associate($user);
        $category->save();

        return $category;
    }

}

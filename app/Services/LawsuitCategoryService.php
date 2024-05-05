<?php

namespace App\Services;

use App\Models\LawsuitCategory;
use App\Models\User;

class LawsuitCategoryService
{
    public function create(array $params, User $user): LawsuitCategory
    {
        $category = app(LawsuitCategory::class)->fill($params);
        $category->user()->associate($user);
        $category->save();

        return $category;
    }

}

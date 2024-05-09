<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\LawsuitCategory;
use App\Models\User;

class LawsuitCategoryService
{
    private ?LawsuitCategory $lawsuitCategory;

    public function __construct(?LawsuitCategory $lawsuitCategory)
    {
        $this->lawsuitCategory = $lawsuitCategory;
    }

    public function create(array $params, User $user): LawsuitCategory
    {
        $category = app(LawsuitCategory::class)->fill($params);
        $category->user()->associate($user);
        $category->save();

        return $category;
    }

    public function delete(): void
    {
        if ($this->lawsuitCategory->lawsuits()->exists()) {
            throw new ServiceException('В категории есть дела, удалить нельзя');
        }
        $this->lawsuitCategory->delete();
    }
}

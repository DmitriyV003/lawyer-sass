<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\LawsuitEventCategory;
use App\Models\TaskTag;
use App\Models\User;

class LawsuitEventCategoryService
{
    private ?LawsuitEventCategory $lawsuitEventCategory;

    public function __construct(?LawsuitEventCategory $lawsuitEventCategory)
    {
        $this->lawsuitEventCategory = $lawsuitEventCategory;
    }

    public function create(array $params, User $user): LawsuitEventCategory
    {
        $lawsuitEventCategory = app(LawsuitEventCategory::class)->fill($params);
        $lawsuitEventCategory->user()->associate($user);
        $lawsuitEventCategory->save();

        return $lawsuitEventCategory;
    }

    public function delete(): void
    {
        if ($this->lawsuitEventCategory->lawsuitEvents()->exists()) {
            throw new ServiceException('В категории есть ивенты, удалить нельзя');
        }
        $this->lawsuitEventCategory->delete();
    }

}

<?php

namespace App\Enums;

enum UserType: string
{
    case Lawyer = 'lawyer';
    case Advocate = 'advocate';

    public static function labels(): array
    {
        return [
            UserType::Lawyer->value => 'юрист',
            UserType::Advocate->value => 'адвокат',
        ];
    }
}

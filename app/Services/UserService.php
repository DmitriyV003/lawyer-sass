<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private ?User $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    public function create(array $params): void
    {
        $user = app(User::class)->fill($params);
        $user->password = Hash::make($params['password']);
        $user->assignRole(User::ADVOCATE_ROLE);
        $user->save();
    }

    public function createAdmin(array $params): void
    {
        $user = app(User::class)->fill($params);
        $user->name = '';
        $user->lastname = '';
        $user->type = '';
        $user->password = Hash::make($params['password']);
        $user->assignRole(User::SUPER_ADMIN_ROLE);
        $user->save();
    }

    public function updatePassword(array $params): void
    {
        if (!Hash::check($params['password'], $this->user->password)) {
            throw new ServiceException('Неверный пароль', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->user->password = Hash::make($params['new_password']);
        $this->user->save();
    }

    public function update(array $params): User
    {
        $this->user->update($params);

        return $this->user;
    }

    public function delete(): void
    {
        $this->user->is_active = false;
        $this->user->save();
        $this->user->delete();
    }
}

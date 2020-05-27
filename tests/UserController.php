<?php

namespace App\Http\Controllers\EXP;

use App\Models\User;
use App\ReflexAPI\ModelReflector;
use App\ReflexAPI\ResourceController;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class UserController extends ResourceController
{
    protected function getModelReflector(): ModelReflector
    {
        return new ModelReflector(User::class);
    }

    protected function getStoreRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users']
        ];
    }
}

<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    public function getModelClass(): string
    {
        return User::class;
    }
}

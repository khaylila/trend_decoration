<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel;

class OwnUserModel extends UserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
            'first_name',
            'last_name',
            'phone_number',
            'gender',
            'birth_date ',
            'full_address',
            'avatar',
        ];
    }
}

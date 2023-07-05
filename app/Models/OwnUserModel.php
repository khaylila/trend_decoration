<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Database\RawSql;

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
            'birth_date',
            'full_address',
            'avatar',
            'factory_id',
        ];
    }

    protected $afterFind     = ['fetchIdentities'];
    protected $afterInsert   = ['saveEmailIdentity', 'logInsert'];
    protected $afterUpdate   = ['saveEmailIdentity', 'logUpdate'];
    protected $afterDelete    = ['logDelete'];

    protected function logInsert(array $data)
    {
        $this->logging($data, 'insert', $this->table);
    }

    protected function logUpdate(array $data)
    {
        $this->logging($data, 'update', $this->table);
    }

    protected function logDelete(array $data)
    {
        $this->logging($data, 'delete', $this->table);
    }

    protected function logging(array $data, string $action, string $table)
    {
        db_connect()->table("logs")->insert([
            'user_id' => user_id(),
            'table_name' => $table,
            'action' => $action,
            'extra' => json_encode($data),
            'created_at' => new RawSql('CURRENT_TIMESTAMP()'),
        ]);
    }
}

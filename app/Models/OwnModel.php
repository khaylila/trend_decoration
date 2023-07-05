<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;

class OwnModel extends Model
{
    protected $afterInsert    = ['logInsert'];
    protected $afterUpdate    = ['logUpdate'];
    protected $afterDelete    = ['logDelete'];

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
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'logs';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['user_id', 'table_name', 'action', 'extra', 'created_at'];
}

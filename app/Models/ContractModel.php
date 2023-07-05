<?php

namespace App\Models;

class ContractModel extends OwnModel
{
    protected $table      = 'contracts';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['factory_id', 'date', 'customer_name', 'customer_address', 'customer_sign'];

    // Dates
    protected $useTimestamps = true;

    protected $afterInsert    = ['logInsert'];
    protected $afterUpdate    = ['logUpdate'];
    protected $afterDelete    = ['logDelete'];
}

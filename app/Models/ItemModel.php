<?php

namespace App\Models;

class ItemModel extends OwnModel
{
    protected $table      = 'items';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['contract_id', 'product_id', 'qty'];

    // Dates
    protected $useTimestamps = true;

    protected $afterInsert    = ['logInsert'];
    protected $afterUpdate    = ['logUpdate'];
    protected $afterDelete    = ['logDelete'];
}

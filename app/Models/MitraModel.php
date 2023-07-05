<?php

namespace App\Models;

class MitraModel extends OwnModel
{
    protected $table      = 'mitra';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'address', 'npwp', 'avatar'];

    // Dates
    protected $useTimestamps = true;

    protected $afterInsert    = ['logInsert'];
    protected $afterUpdate    = ['logUpdate'];
    protected $afterDelete    = ['logDelete'];
}

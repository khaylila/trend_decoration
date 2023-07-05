<?php

namespace App\Models;

class ProductImageModel extends OwnModel
{
    protected $table      = 'product_images';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['product_id', 'image'];

    protected $afterInsert    = ['logInsert'];
    protected $afterUpdate    = ['logUpdate'];
    protected $afterDelete    = ['logDelete'];
}

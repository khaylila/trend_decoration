<?php

namespace App\Models;

class ProductModel extends OwnModel
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['factory_id', 'name', 'desc', 'price', 'qty'];

    // Dates
    protected $useTimestamps = true;

    protected $afterInsert    = ['logInsert'];
    protected $afterUpdate    = ['logUpdate'];
    protected $afterDelete    = ['logDelete'];

    protected function findProductImageModelID($id)
    {
        $productID = model(ProductImageModel::class)->select('product_id')->find($id)['product_id'] ?? null;
        if ($productID === null) {
            return null;
        }

        return $this->select('factory_id')->find($productID)['factory_id'] ?? null;
    }
}

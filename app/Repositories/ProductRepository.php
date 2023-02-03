<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    CONST relations = [
        'sales'
    ];
    public function __construct(Product $product)
    {
        parent::__construct($product, self::relations);
    }

    public function getOneByReference($reference)
    {
        return $this->model->firstWhere('reference', $reference);
    }

}

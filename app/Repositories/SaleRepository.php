<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Sale;

class SaleRepository extends BaseRepository
{
    public function __construct(Sale $sale)
    {
        parent::__construct($sale);
    }
}

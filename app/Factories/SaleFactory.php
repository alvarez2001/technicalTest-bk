<?php

namespace App\Factories;

use App\Models\Sale;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use ErrorException;

class SaleFactory
{
    private ProductRepository $productRepository;
    private SaleRepository $saleRepository;
    public function __construct( ProductRepository $productRepository, SaleRepository $saleRepository )
    {
        $this->productRepository = $productRepository;
        $this->saleRepository = $saleRepository;
    }

    /**
     * @throws ErrorException
     */
    private function baseInstance($data, $saleId = null): array
    {
        if(!is_null($saleId))
        {
            $sale = $this->saleRepository->getOne($saleId);
            $data['product_id'] = $sale->product_id;
        }

        $product = $this->productRepository->getOne($data['product_id']);

        $product->fill([
            'stock'=> is_null($saleId) ? $this->subtractProductStockAndQuantity( $product->stock, $data['quantity'] ) :
                $this->subtractProductStockAndQuantity( $this->addProductStockAndQuantity($product->stock, $sale->quantity), $data['quantity'] )
        ]);

        if($product->stock < 0)
        {
            throw new ErrorException('quantity is greater than available stock');
        }

        $data =  $this->mergeAttribute($data, $product->price);

        if(!is_null($saleId))
        {
            $sale->fill($data);
        }

        return [
            'sale' => is_null($saleId) ? $this->getInstanceModel($data) : $sale,
            'product' => $product,
        ];

    }

    public function createInstance($data): array
    {
        return $this->baseInstance($data);
    }

    public function updateInstance($data, $saleId): array
    {
        return $this->baseInstance($data, $saleId);
    }

    public function deleteInstance($saleId): array
    {
        $sale = $this->saleRepository->getOne($saleId);
        $sale->product->fill([
            'stock'=> $sale->product->stock + $sale->quantity
        ]);

        return [
            'sale' => $sale,
            'product' => $sale->product,
        ];



    }


    private function mergeAttribute($data, $price): array
    {
        return array_merge(
            $data,
            [
                'product_id' => $data['product_id'],
                'unit_price' => $price,
                'total_price' => $data['quantity'] * $price,
            ]
        );
    }

    private function getInstanceModel( array $attributes): Sale
    {
        return new Sale($attributes);
    }

    private function addProductStockAndQuantity($stock, $quantity): int
    {
        return $stock + $quantity;
    }

    private function subtractProductStockAndQuantity($stock, $quantity): int
    {
        return $stock - $quantity;
    }


}

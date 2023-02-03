<?php

namespace App\Http\Controllers;

use App\Factories\SaleFactory;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    private SaleRepository $saleRepository;
    private ProductRepository $productRepository;
    private SaleFactory $saleFactory;
    public function __construct( SaleRepository $saleRepository, ProductRepository $productRepository, SaleFactory $saleFactory )
    {
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
        $this->saleFactory = $saleFactory;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->saleRepository->getAll(), Response::HTTP_OK);
    }

    public function store(StoreSaleRequest $request): JsonResponse
    {
        try {
            $instances = $this->saleFactory->createInstance($request->validated());
        } catch (\ErrorException $exception) {
            return response()->json(['error' => [
                $exception->getMessage()
            ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $sale = $this->saleRepository->saveModel($instances['sale']);
        $this->productRepository->saveModel($instances['product']);
        return response()->json($sale, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $sale = $this->saleRepository->getOne($id);
        return response()->json($sale, Response::HTTP_OK);
    }

    public function update(UpdateSaleRequest $request, int $id): JsonResponse
    {
        try {
            $instances = $this->saleFactory->updateInstance($request->validated(), $id);
        } catch (\ErrorException $exception) {
            return response()->json(['error' => [
                $exception->getMessage()
            ]], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $sale = $this->saleRepository->saveModel($instances['sale']);
        $this->productRepository->saveModel($instances['product']);
        return response()->json($sale, Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $instances = $this->saleFactory->deleteInstance($id);
        $this->productRepository->saveModel($instances['product']);
        $sale = $this->saleRepository->deleteModel($instances['sale']);
        return response()->json($sale, Response::HTTP_NO_CONTENT);
    }
}

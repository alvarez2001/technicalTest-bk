<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    private ProductRepository $productRepository;
    public function __construct( ProductRepository $productRepository )
    {
        $this->productRepository = $productRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->productRepository->getAll(), Response::HTTP_OK);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = new Product($request->validated());
        $product = $this->productRepository->saveModel($product);
        return response()->json($product, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->productRepository->getOne($id);
        return response()->json($product, Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->productRepository->getOne($id);
        $product->fill($request->validated());
        $product = $this->productRepository->saveModel($product);
        return response()->json($product, Response::HTTP_OK);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product = $this->productRepository->deleteModel($product);
        return response()->json($product, Response::HTTP_NO_CONTENT);

    }

    public function showByReference($reference): JsonResponse
    {
        $product = $this->productRepository->getOneByReference($reference);

        if(is_null($product))
        {
            return response()->json(['error' => [
                'the reference does not exist'
            ]], Response::HTTP_NOT_FOUND);
        }
        return response()->json($product, Response::HTTP_OK);
    }
}

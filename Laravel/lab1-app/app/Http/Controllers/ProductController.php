<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

        $this->middleware('role:ROLE_ADMIN,ROLE_MANAGER')->only(['store', 'create', 'edit', 'update', 'destroy']);
        $this->middleware('role:ROLE_CLIENT')->only(['index', 'show']);
    }

    private const PRODUCTS = [
        1 => ['id' => 1, 'name' => 'Laptop', 'description' => 'Gaming Laptop', 'price' => 1000],
        2 => ['id' => 2, 'name' => 'Phone', 'description' => 'Smartphone', 'price' => 500],
        ];
    private function getProductItemById(array $products, $id): ?array
    {
        return $products[$id] ?? null;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => self::PRODUCTS], 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json(['data' => ['error' => 'Product not found']], 404);
        }

        return response()->json(['data' => $product], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['name', 'description', 'price']);
        $id = random_int(100, 999);

        $newProduct = [
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
        ];

        // TODO: insert to DB

        return response()->json(['data' => $newProduct], 201);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json(['data' => ['error' => 'Product not found']], 404);
        }

        $data = $request->only(['name', 'description', 'price']);

        $updatedProduct = [
            'id' => $id,
            'name' => $data['name'] ?? $product['name'],
            'description' => $data['description'] ?? $product['description'],
            'price' => $data['price'] ?? $product['price'],
        ];

        // TODO: update in DB

        return response()->json(['data' => $updatedProduct], 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return response()->json(['data' => ['error' => 'Product not found']], 404);
        }

        // TODO: delete from DB

        return response()->json(['message' => "Product with ID $id deleted"], 200);
    }
}

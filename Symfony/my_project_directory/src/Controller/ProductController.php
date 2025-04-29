<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends AbstractController
{
    private const PRODUCTS = [
        1 => ['id' => 1, 'name' => 'Laptop', 'description' => 'Gaming Laptop', 'price' => 1000],
        2 => ['id' => 2, 'name' => 'Phone', 'description' => 'Smartphone', 'price' => 500],
    ];

    private function getProductItemById(array $products, string|int $id): ?array
    {
        return $products[$id] ?? null;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/products', name: 'get_products', methods: [Request::METHOD_GET])]
    public function getProducts(): JsonResponse
    {
        return new JsonResponse(['data' => self::PRODUCTS], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'get_product_item', methods: [Request::METHOD_GET])]
    public function getProductItem(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Not found product by id ' . $id]], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['data' => $product], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/products', name: 'post_products', methods: [Request::METHOD_POST])]
    public function createProduct(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $productId = random_int(100, 999);

        $newProductData = [
            'id' => $productId,
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'price' => $requestData['price']
        ];

        // TODO: insert to db

        return new JsonResponse(['data' => $newProductData], Response::HTTP_CREATED);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'put_product', methods: [Request::METHOD_PUT])]
    public function updateProduct(string $id, Request $request): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Product not found']], Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        $updatedProduct = [
            'id' => $id,
            'name' => $requestData['name'] ?? $product['name'],
            'description' => $requestData['description'] ?? $product['description'],
            'price' => $requestData['price'] ?? $product['price'],
        ];

        // TODO: update in db

        return new JsonResponse(['data' => $updatedProduct], Response::HTTP_OK);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('/products/{id}', name: 'delete_product', methods: [Request::METHOD_DELETE])]
    public function deleteProduct(string $id): JsonResponse
    {
        $product = $this->getProductItemById(self::PRODUCTS, $id);

        if (!$product) {
            return new JsonResponse(['data' => ['error' => 'Product not found']], Response::HTTP_NOT_FOUND);
        }

        // TODO: delete from db

        return new JsonResponse(['message' => "Product with ID $id deleted"], Response::HTTP_OK);
    }
}

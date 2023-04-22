<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\APIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    public function __construct(private readonly APIService $apiService)
    {
    }

    #[Route('/api/products/', name: 'product_list', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, Request $request): JsonResponse
    {
        // Default pagination values
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 5);

        $products = $productRepository->findAllWithPagination($page, $limit);

        return $this->apiService->get($products, ['product:read']);
    }

    #[Route('/api/products/{id}', name: 'product_detail', methods: ['GET'])]
    public function getProduct(Product $product): JsonResponse
    {
        return $this->apiService->get($product, ['product:read']);
    }
}

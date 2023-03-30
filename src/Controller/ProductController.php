<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\APIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private APIService $apiService;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->apiService = new APIService($serializer, $em);
    }

    #[Route('/api/products/', name: 'product_list', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        return $this->apiService->getRoutes($products, ['product:read']);
    }

    #[Route('/api/products/{id}', name: 'product_detail', methods: ['GET'])]
    public function getProduct(Product $product): JsonResponse
    {
        return $this->apiService->getRoutes($product, ['product:read']);
    }
}

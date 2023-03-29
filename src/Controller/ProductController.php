<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ProductController extends AbstractController
{
    #[Route('/api/products/', name: 'product_list', methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $productList = $productRepository->findAll();

        $circularReferenceHandler = function ($object) {
            return $object->getId();
        };

        $jsonProductList = $serializer->serialize($productList, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => $circularReferenceHandler,
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['brand'],
        ]);

        return new JsonResponse($jsonProductList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/products/{id}', name: 'product_detail', methods: ['GET'])]
    public function getProduct(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $circularReferenceHandler = function ($object) {
            return $object->getId();
        };

        $jsonProduct = $serializer->serialize($product, 'json', [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => $circularReferenceHandler,
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['brand'],
        ]);

        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
}

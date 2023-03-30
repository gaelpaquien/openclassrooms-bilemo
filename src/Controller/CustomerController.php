<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\APIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private APIService $apiService;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->apiService = new APIService($serializer, $em);
    }

    #[Route('/api/companies/{companyId}/customers', name: 'customer_list', methods: ['GET'])]
    public function getAllCustomers(CustomerRepository $customerRepository, int $companyId): JsonResponse
    {
        $customers = $customerRepository->findBy(['company' => $companyId]);

        return $this->apiService->getRoutes($customers, ['customer:read']);
    }

    #[Route('/api/companies/{companyId}/customers/{id}', name: 'customer_detail', methods: ['GET'])]
    public function getCustomer(Customer $customer): JsonResponse
    {
        return $this->apiService->getRoutes($customer, ['customer:read']);
    }

    #[Route('/api/companies/{companyId}/customers/{id}', name: 'customer_delete', methods: ['DELETE'])]
    public function deleteCustomer(Customer $customer): JsonResponse
    {
        return $this->apiService->deleteRoutes($customer);
    }
}

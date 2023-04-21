<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\APIService;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CustomerController extends AbstractController
{
    public function __construct(private readonly APIService $apiService, private readonly CustomerService $customerService)
    {
    }

    #[Route('/api/companies/{companyId}/customers', name: 'customer_create', methods: ['POST'])]
    public function createCustomer(Request $request): JsonResponse
    {
        $result = $this->customerService->createCustomer($request);

        // If the customer is an instance of JsonResponse, it means that there is an error validating the data
        if ($result instanceof JsonResponse) {
            return $result;
        }

        return $this->apiService->post($result['customer'], $result['location'], ['customer:read']);
    }

    #[Route('/api/companies/{companyId}/customers', name: 'customer_list', methods: ['GET'])]
    public function getAllCustomers(CustomerRepository $customerRepository, int $companyId): JsonResponse
    {
        $customers = $customerRepository->findBy(['company' => $companyId]);

        return $this->apiService->get($customers, ['customer:read']);
    }

    #[Route('/api/companies/{companyId}/customers/{id}', name: 'customer_detail', methods: ['GET'])]
    public function getCustomer(Customer $customer): JsonResponse
    {
        return $this->apiService->get($customer, ['customer:read']);
    }

    #[Route('/api/companies/{companyId}/customers/{id}', name: 'customer_delete', methods: ['DELETE'])]
    public function deleteCustomer(Customer $customer): JsonResponse
    {
        return $this->apiService->delete($customer);
    }
}

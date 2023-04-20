<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\APIService;
use App\Service\CustomerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private APIService $apiService;

    private CustomerService $customerService;

    public function __construct(APIService $apiService, CustomerService $customerService)
    {
        $this->apiService = $apiService;
        $this->customerService = $customerService;
    }

    #[Route('/api/companies/{companyId}/customers', name: 'customer_create', methods: ['POST'])]
    public function createCustomer(Request $request): JsonResponse 
    {
        $customer = $this->customerService->createCustomer($request);

        return $this->apiService->post($customer, 'customer_detail', ['customer:read']);
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

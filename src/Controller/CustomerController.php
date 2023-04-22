<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\APIService;
use App\Service\CustomerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un nouveau client')]
    public function createCustomer(Request $request): JsonResponse
    {
        return $this->customerService->createCustomer($request);
    }

    #[Route('/api/companies/{companyId}/customers', name: 'customer_list', methods: ['GET'])]
    public function getAllCustomers(CustomerRepository $customerRepository, int $companyId, Request $request): JsonResponse
    {
        // Default pagination values
        $page = (int) $request->query->get('page', 1);
        $limit = (int) $request->query->get('limit', 5);

        $customers = $customerRepository->findAllWithPaginationByCompany($companyId, $page, $limit);

        $idCache = sprintf('customer_list_page_%d_limit_%d', $page, $limit);

        return $this->apiService->get($customers, ['customer:read'], $idCache, 'customer_tag');
    }

    #[Route('/api/companies/{companyId}/customers/{id}', name: 'customer_detail', methods: ['GET'])]
    public function getCustomer(Customer $customer): JsonResponse
    {
        $idCache = sprintf('customer_detail_%s', $customer->getId());

        return $this->apiService->get($customer, ['customer:read'], $idCache, 'customer_tag');
    }

    #[Route('/api/companies/{companyId}/customers/{id}', name: 'customer_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: "Vous n'avez pas les droits suffisants pour supprimer un client")]
    public function deleteCustomer(Customer $customer): JsonResponse
    {
        return $this->apiService->delete($customer, ['customer_tag']);
    }
}

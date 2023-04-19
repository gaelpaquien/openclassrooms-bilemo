<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use App\Repository\CompanyRepository;
use App\Repository\CustomerRepository;
use App\Service\APIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerController extends AbstractController
{
    private APIService $apiService;

    public function __construct(APIService $apiService)
    {
        $this->apiService = $apiService;
    }

    #[Route('/api/companies/{companyId}/customers', name: 'customer_create', methods: ['POST'])]
    public function createCustomer(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator, CompanyRepository $companyRepository): JsonResponse 
    {
        // Recovers all the data that has been sent
        $content = $request->toArray();

        $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        // Recovers the company id and sets it to the customer
        $idCompany = $content['company_id'];
        $customer->setCompany($companyRepository->find($idCompany));

        // Recovers the address informations and sets it to the customer
        $address = new CustomerAddress();
        $address->setCustomer($customer);
        $address->setCountry($content['address']['country']);
        $address->setCity($content['address']['city']);
        $address->setPostalCode($content['address']['postal_code']);
        $address->setAddress($content['address']['address']);
        $address->setAddressDetails($content['address']['address_details']);

        /*
{
    "company_id": 1,
    "username": "test8",
    "email": "test8@email.fr",
    "password": "test",
    "phone_number": "0102030405"
    "address": {
        "country": "Paris",
        "city": "Paris",
        "postal_code": "75001"
        "address": "123 Rue du test"
    }
}
        */

        $em->persist($customer);
        $em->flush();

        $jsonCustomer = $serializer->serialize($customer, 'json', ['groups' => 'customer:read']);

        $location = $urlGenerator->generate('customer_detail', [
            'id' => $customer->getId(), 
            'companyId' => $customer->getCompany()->getId()
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonCustomer, Response::HTTP_CREATED, ["Location" => $location], true);
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

<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class CustomerService
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly CompanyRepository $companyRepository, private readonly EntityManagerInterface $em)
    {
    }

    public function createCustomer(Request $request): Customer
    {
        // Recovers all the data that has been sent
        $content = $request->toArray();

        $customer = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');

        // Recovers the company id and sets it to the customer
        $idCompany = $content['company_id'];
        $customer->setCompany($this->companyRepository->find($idCompany));

        // Recovers the address informations and sets it to the customer
        $address = new CustomerAddress();
        $address->setCustomer($customer);
        $address->setCountry($content['address']['country']);
        $address->setCity($content['address']['city']);
        $address->setPostalCode($content['address']['postal_code']);
        $address->setAddress($content['address']['address']);
        $address->setAddressDetails($content['address']['address_details'] ?? null);

        $customer->addCustomerAddress($address);

        $this->em->persist($customer);
        $this->em->persist($address);
        $this->em->flush();

        return $customer;
    }
}

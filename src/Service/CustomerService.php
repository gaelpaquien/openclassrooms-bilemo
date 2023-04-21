<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;
use App\Entity\CustomerAddress;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CustomerService
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly CompanyRepository $companyRepository, private readonly EntityManagerInterface $em, private readonly ValidatorInterface $validator)
    {
    }

    public function createCustomer(Request $request): Customer | JsonResponse
    {
        // Recovers all the data that has been sent
        $content = $request->toArray();

        $customer = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');

        // Recovers the company and checks if it exists
        $companyId = $request->attributes->get('companyId');
        $companyExists = $this->companyRepository->findOneBy(['id' => $companyId]);
        if (!$companyExists) {
            return new JsonResponse('Cette entreprise n\'existe pas', Response::HTTP_BAD_REQUEST, [], true);
        }

        // Sets the company to the customer
        $customer->setCompany($this->companyRepository->find($companyId));

        // Recovers the address informations and sets it to the customer
        $address = new CustomerAddress();
        $address->setCustomer($customer);
        $address->setCountry($content['address']['country']);
        $address->setCity($content['address']['city']);
        $address->setPostalCode($content['address']['postal_code']);
        $address->setAddress($content['address']['address']);
        $address->setAddressDetails(($content['address']['address_details'] ?? null));

        $customer->addCustomerAddress($address);

        // Validates the customer and the address
        $customerErrors = $this->validator->validate($customer);
        $addressErrors = $this->validator->validate($address);
        $errors = array_merge($customerErrors->getIterator()->getArrayCopy(), $addressErrors->getIterator()->getArrayCopy());

        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $property = $error->getPropertyPath();
                $message = (string) $error;
                $messages[$property] = $message;
            }

            $jsonResponse = json_encode($messages, JSON_PRETTY_PRINT);
            return new JsonResponse($jsonResponse, Response::HTTP_BAD_REQUEST, [], true);
        }

        // Check if the customer already exists
        $customerExists = $this->em->getRepository(Customer::class)->findOneBy(['email' => $customer->getEmail()]);
        if ($customerExists) {
            return new JsonResponse('Cet email est déjà utilisé', Response::HTTP_BAD_REQUEST, [], true);
        }

        $this->em->persist($customer);
        $this->em->persist($address);
        $this->em->flush();

        return $customer;
    }
}

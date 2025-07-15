<?php

namespace App\Tests\Api;

use App\Entity\Company;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

class ContactApiTest extends AbstractApiTestCase
{
    public function testGetCollection(): void
    {
        $client = $this->createAuthenticatedClient();
        $response = $client->request('GET', '/api/contacts', ['headers' => ['Accept' => 'application/ld+json']]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/api/contacts']);
    }

    public function testCreateContact(): void
    {
        $client = $this->createAuthenticatedClient();
        $company = $this->createCompany();

        $response = $client->request('POST', '/api/contacts', [
            'headers' => ['Content-Type' => 'application/ld+json', 'Accept' => 'application/ld+json'],
            'json' => [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '0123456789',
                'company' => '/api/companies/' . $company->getId(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '0123456789',
        ]);
    }

    public function testUpdateContact(): void
    {
        $client = $this->createAuthenticatedClient();
        $contact = $this->createContact();

        $response = $client->request('PATCH', '/api/contacts/' . $contact->getId(), [
            'headers' => ['Content-Type' => 'application/merge-patch+json', 'Accept' => 'application/ld+json'],
            'json' => [
                'firstname' => 'Jane',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'firstname' => 'Jane',
        ]);
    }

    public function testDeleteContact(): void
    {
        $client = $this->createAuthenticatedClient();
        $contact = $this->createContact();

        $client->request('DELETE', '/api/contacts/' . $contact->getId(), ['headers' => ['Accept' => 'application/ld+json']]);

        $this->assertResponseStatusCodeSame(204);

        // Verify that the contact is actually deleted
        $this->assertNull(
            static::getContainer()->get(EntityManagerInterface::class)->getRepository(Contact::class)->find($contact->getId())
        );
    }

    private function createCompany(): Company
    {
        $company = new Company();
        $company->setName('Company');
        $company->setDescription('Description');
        $company->setWebsite('https://example.com');
        $company->setAddress('Address');
        $company->setPhone('0123456789');

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $em->persist($company);
        $em->flush();

        return $company;
    }

    private function createContact(): Contact
    {
        $contact = new Contact();
        $contact->setFirstname('John');
        $contact->setLastname('Doe');
        $contact->setEmail('john.doe@example.com');
        $contact->setPhone('0123456789');
        $contact->setCompany($this->createCompany());

        $em = static::getContainer()->get(EntityManagerInterface::class);
        $em->persist($contact);
        $em->flush();

        return $contact;
    }
}

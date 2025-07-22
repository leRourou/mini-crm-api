<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class AbstractApiTestCase extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();
        $em = $container->get(EntityManagerInterface::class);

        $metadatas = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema($metadatas);
        $schemaTool->createSchema($metadatas);
    }

    protected function createAuthenticatedClient(string $email = 'test@example.com', string $password = 'password'): Client
    {
        $client = static::createClient();
        $container = static::getContainer();

        $em = $container->get(EntityManagerInterface::class);
        $passwordHasher = $container->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword($user, $password));

        $em->persist($user);
        $em->flush();

        $response = $client->request('POST', '/api/login_check', [
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        $data = $response->toArray();
        $client->setDefaultOptions([
            'headers' => ['Authorization' => 'Bearer ' . $data['token']],
        ]);

        return $client;
    }
}

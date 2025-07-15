<?php

namespace App\Security;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder,
        private UserRepository        $userRepository
    ) {}

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization')
            && str_starts_with($request->headers->get('Authorization'), 'Bearer ');
    }

    public function authenticate(Request $request): Passport
    {
        $authHeader = $request->headers->get('Authorization');
        $jwt = substr($authHeader, 7);

        try {
            $data = $this->jwtEncoder->decode($jwt);
        } catch (\Exception $e) {
            throw new CustomUserMessageAuthenticationException('Token JWT invalide ou expiré');
        }

        if (!isset($data['username'])) {
            throw new CustomUserMessageAuthenticationException('Le token JWT ne contient pas d\'identifiant utilisateur');
        }

        return new SelfValidatingPassport(new UserBadge($data['username'], function (string $userIdentifier): UserInterface {
            $user = $this->userRepository->findOneBy(['username' => $userIdentifier]);
            if (!$user) {
                throw new CustomUserMessageAuthenticationException('Utilisateur introuvable');
            }
            return $user;
        }));
    }

    public function onAuthenticationSuccess(Request $request, $token, string $firewallName): ?Response
    {
        // Rien à faire, on laisse la requête continuer
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => $exception->getMessage(),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}

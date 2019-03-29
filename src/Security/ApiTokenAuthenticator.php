<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\Security;

use Ang3\Bundle\ApiBasicAuthBundle\Model\ApiUserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * @author Joanis ROUANET
 */
class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * {@inheritdoc}.
     */
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }

    /**
     * {@inheritdoc}.
     */
    public function getCredentials(Request $request)
    {
        // Récupération de l'entête d'autorization
        $authorizationHeaderValue = $request->headers->get('Authorization');

        // Si on a un tableau
        if (is_array($authorizationHeaderValue) || !$authorizationHeaderValue) {
            // Pas d'identifiant
            return array();
        }

        // Si ce n'est pas une authentification "basique"
        if ('Basic ' != substr($authorizationHeaderValue, 0, 6)) {
            // Pas d'identifiant
            return array();
        }

        // Récupération et décodage de l'entête
        $authorization = base64_decode(substr($authorizationHeaderValue, 6));

        // Si la chaîne d'autorisation n'est pas correctement formatée
        if (false === $authorization || !preg_match('#^(\w+):([0-9a-f]+)$#', $authorization, $matches)) {
            // Pas d'identifiant
            return array();
        }

        // Retour des identifiants
        return array(
            'username' => $matches[1],
            'apiKey' => $matches[2],
        );
    }

    /**
     * {@inheritdoc}.
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // Si d'identifiants
        if (!array_key_exists('username', $credentials)) {
            // Pas d'utilisateur
            return;
        }

        // Retour de l'éventuel utilisateur chargé
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    /**
     * {@inheritdoc}.
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // Si d'identifiants
        if (!isset($credentials['apiKey'])) {
            // Retour négatif
            return false;
        }

        // Si l'utilisateur n'est pas de l'instance souhaitée
        if (!($user instanceof ApiUserInterface)) {
            // Retour négatif
            return false;
        }

        // Si la clé API est invalide
        if ($credentials['apiKey'] !== $user->getApiKey()) {
            // Retour négatif
            return false;
        }

        // Return true to cause authentication success
        return true;
    }

    /**
     * {@inheritdoc}.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    /**
     * {@inheritdoc}.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'code' => Response::HTTP_FORBIDDEN,
            'message' => 'Authentication failed.',
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * {@inheritdoc}.
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'code' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Authentication required.',
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritdoc}.
     */
    public function supportsRememberMe()
    {
        return false;
    }
}

<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\Security;

use Ang3\Bundle\ApiBasicAuthBundle\Model\ApiUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @author Joanis ROUANET
 */
class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * Custom user provider.
     *
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * Constructor of the generator.
     *
     * @param UserProviderInterface $userProvider
     */
    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * {@inheritdoc}.
     */
    public function loadUserByUsername($username)
    {
        return $this->userProvider->loadUserByUsername($username);
    }

    /**
     * {@inheritdoc}.
     */
    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritdoc}.
     */
    public function supportsClass($class)
    {
        // Récupération des interfaces de la classe
        $interfaces = class_implements($class);

        // Retour du test d'implémentation de l'interface d'utilisateur API
        return isset($interfaces[ApiUserInterface::class]);
    }
}

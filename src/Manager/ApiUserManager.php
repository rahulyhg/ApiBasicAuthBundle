<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\Manager;

use Ang3\Bundle\ApiBasicAuthBundle\Model\ApiUserInterface;
use Ang3\Bundle\ApiBasicAuthBundle\Utils\ApiKeyGenerator;

/**
 * @author Joanis ROUANET
 */
class ApiUserManager
{
    /**
     * Générateur de clés.
     *
     * @var ApiKeyGenerator
     */
    protected $apiKeyGenerator;

    /**
     * Constructor of the subscriber.
     *
     * @param ApiKeyGenerator $apiKeyGenerator
     */
    public function __construct(ApiKeyGenerator $apiKeyGenerator)
    {
        $this->apiKeyGenerator = $apiKeyGenerator;
    }

    /**
     * Update the API of an API user.
     *
     * @param ApiUserInterface $user
     * @param string|null      $apiKey
     *
     * @return ApiUserInterface
     */
    public function updateApiKey(ApiUserInterface $user, $apiKey = null)
    {
        // Hydratation d'une nouvelle clé
        $user->setApiKey($apiKey ?: $this->apiKeyGenerator->generate());

        // Retour de l'utilisateur
        return $user;
    }

    /**
     * Generate a new API key.
     *
     * @return string
     */
    public function generateApiKey()
    {
        return $this->apiKeyGenerator->generate();
    }
}

<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\Model;

/**
 * @author Joanis ROUANET
 */
interface ApiUserInterface
{
    /**
     * Sets apiKey.
     *
     * @param string $apiKey
     *
     * @return self
     */
    public function setApiKey($apiKey);

    /**
     * Gets apiKey.
     *
     * @return string
     */
    public function getApiKey();
}

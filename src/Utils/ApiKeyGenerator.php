<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\Utils;

/**
 * @author Joanis ROUANET
 */
class ApiKeyGenerator
{
    /**
     * Generates a new unique API Key.
     *
     * @return string
     */
    public function generate()
    {
        return sha1(uniqid((string) rand(999, 9999999), true).uniqid((string) rand(999, 9999999), true));
    }
}

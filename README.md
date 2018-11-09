Ang3 API basic authentication bundle
====================================

[![Build Status](https://travis-ci.org/Ang3/ApiBasicAuthBundle.svg?branch=master)](https://travis-ci.org/Ang3/ApiBasicAuthBundle) [![Latest Stable Version](https://poser.pugx.org/ang3/api-basic-auth-bundle/v/stable)](https://packagist.org/packages/ang3/api-basic-auth-bundle) [![Latest Unstable Version](https://poser.pugx.org/ang3/api-basic-auth-bundle/v/unstable)](https://packagist.org/packages/ang3/api-basic-auth-bundle) [![Total Downloads](https://poser.pugx.org/ang3/api-basic-auth-bundle/downloads)](https://packagist.org/packages/ang3/api-basic-auth-bundle)

This Symfony bundle helps you to install basic authentication easily for your API.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require ang3/api-basic-auth-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
  public function registerBundles()
  {
    $bundles = array(
      // ...
      new Ang3\Bundle\ApiBasicAuthBundle\Ang3ApiBasicAuthBundle(),
    );

    // ...
  }

  // ...
}
```

Step 3: Configure your app
--------------------------

Configure the user provider to use for authentication. The FOS user provider is registered by default.

```yaml
# app/config/config.yml
ang3_api_basic_auth:
  user_provider: ~ # default value : fos_user.user_provider.username
```

Step 4: Securize your app
--------------------------

```yaml
# app/config/security.yml
security:
  encoders:
    # ...

  role_hierarchy:
    # ...

  providers:
    # ...
    api_key_user_provider:
      id: Ang3\Bundle\ApiBasicAuthBundle\Security\ApiKeyUserProvider

  firewalls:
    # ...
    api_firewall:
      pattern: ^/api/ # Secured area depending of your app
      stateless: true
      guard:
        authenticators:
          - Ang3\Bundle\ApiBasicAuthBundle\Security\ApiTokenAuthenticator
      provider: api_key_user_provider
      # DEPRECATION : Not setting "logout_on_user_change" to true on firewall "main_login" is deprecated as of 3.4, it will always be true in 4.0.
      logout_on_user_change: true
```
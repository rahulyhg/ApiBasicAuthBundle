<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Joanis ROUANET
 */
class Ang3ApiBasicAuthExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Définition d'un chargeur de fichier YAML
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        /**
         * Récupération de la valeur du paramètre "user_provider".
         *
         * @var string
         */
        $userProvider = $config['user_provider'];

        // Enregistrement d'un alias sur le provider configuré
        $container
            ->setAlias('ang3_api_basic_auth.custom_user_provider', $userProvider)
        ;

        // Chargement des services
        $loader->load('services.yml');
    }
}

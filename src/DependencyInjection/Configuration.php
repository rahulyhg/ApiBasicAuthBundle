<?php

namespace Ang3\Bundle\ApiBasicAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration du bundle.
 *
 * @author Joanis ROUANET
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('ang3_api_basic_auth');

        $rootNode
            ->children()
                ->scalarNode('user_provider')
                    ->cannotBeEmpty()
                    ->defaultValue('fos_user.user_provider.username')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

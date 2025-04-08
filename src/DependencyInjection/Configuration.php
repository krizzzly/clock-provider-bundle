<?php

namespace IWF\ClockProviderBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('clock_provider');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('session_key')
            ->defaultValue('app_date')
            ->info('The session key where the date will be stored')
            ->end()
            ->scalarNode('query_param')
            ->defaultValue('_date')
            ->info('The query parameter that can be used to update the date')
            ->end()
            ->scalarNode('env_var_name')
            ->defaultValue('ENABLE_TIME_WARP')
            ->info('Environment variable to check if time manipulation is enabled')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
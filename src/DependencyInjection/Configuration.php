<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\DependencyInjection;

use Choz\RequestValidationBundle\EventListener\RequestValidationEventListener;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('json_request');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $nodeDefinition */
        $nodeDefinition = $treeBuilder->getRootNode();

        $nodeDefinition
            ->children()
            ->variableNode('custom_exception_event_listener')
            ->defaultValue(RequestValidationEventListener::class)
            ->end()
        ;

        return $treeBuilder;
    }
}

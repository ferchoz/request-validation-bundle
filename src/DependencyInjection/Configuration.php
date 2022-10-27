<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Response;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('json_request');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $nodeDefinition */
        $nodeDefinition = $treeBuilder->getRootNode();

        $nodeDefinition
            ->children()
            ->integerNode('response_code')
            ->defaultValue(Response::HTTP_BAD_REQUEST)
            ->end()
        ;

        return $treeBuilder;
    }
}

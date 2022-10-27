<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\DependencyInjection;

use Choz\RequestValidationBundle\EventListener\RequestValidationEventListener;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\KernelEvents;

final class ChozRequestValidationExtension extends Extension
{
    /** @param array<string,mixed> $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = (new Processor())->processConfiguration(new Configuration(), $configs);

        $container
            ->register('choz_request_validation_listener', RequestValidationEventListener::class)
            ->addArgument($config['response_code'])
            ->addTag('kernel.event_listener', ['event' => KernelEvents::EXCEPTION, 'priority' => 100]);
    }
}

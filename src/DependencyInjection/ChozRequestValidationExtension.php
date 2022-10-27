<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\DependencyInjection;

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

        $container->register($config['custom_exception_event_listener'])
            ->addTag('kernel.event_listener', ['event' => KernelEvents::EXCEPTION, 'priority' => 100]);
    }
}

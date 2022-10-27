<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\DependencyInjection;

use Choz\RequestValidationBundle\EventListener\RequestValidationEventListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\HttpKernel\KernelEvents;

final class ChozRequestValidationExtension extends Extension
{
    /** @param array<string,mixed> $configs */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->register(RequestValidationEventListener::class)
            ->addTag('kernel.event_listener', ['event' => KernelEvents::EXCEPTION, 'priority' => 100]);
    }
}

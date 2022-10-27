<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\DependencyInjection;

use Choz\RequestValidationBundle\DependencyInjection\ChozRequestValidationExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class ChozRequestValidationExtensionTest extends TestCase
{
    public function testExtendionSuccessfully(): void
    {
        $extension = new ChozRequestValidationExtension();

        /** @var \PHPUnit\Framework\MockObject\MockObject $container  */
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())->method('register')->willReturn(new Definition());

        /** @var ContainerBuilder $container  */
        $extension->load([], $container);
    }
}

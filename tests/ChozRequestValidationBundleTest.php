<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests;

use Choz\RequestValidationBundle\ChozRequestValidationBundle;
use PHPUnit\Framework\TestCase;

final class ChozRequestValidationBundleTest extends TestCase
{
    public function testArrayStringError(): void
    {
        $bundle = new ChozRequestValidationBundle();
        $this->assertInstanceOf(ChozRequestValidationBundle::class, $bundle);
    }
}

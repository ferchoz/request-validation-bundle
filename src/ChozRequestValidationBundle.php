<?php

namespace Choz\RequestValidationBundle;

use Choz\RequestValidationBundle\DependencyInjection\RequestValidationExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChozRequestValidationBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface {
        return new RequestValidationExtension();
    }
}

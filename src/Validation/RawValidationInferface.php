<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Validation;

interface RawValidationInferface
{
    public function getRules(): array;
}

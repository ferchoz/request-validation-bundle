<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Validation;

interface RawValidationInferface
{
    /** @return array<int,\Symfony\Component\Validator\Constraint>|array<string,array<int,\Symfony\Component\Validator\Constraint>> */
    public function getRules(): array;
}

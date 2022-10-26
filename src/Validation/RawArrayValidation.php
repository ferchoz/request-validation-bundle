<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Validation;

final class RawArrayValidation implements RawValidationInferface
{
    /** @param array<int,\Symfony\Component\Validator\Constraint> $contraints */
    public function __construct(private array $contraints)
    {
    }

    /** @return array<int,\Symfony\Component\Validator\Constraint> */
    public function getRules(): array
    {
        return $this->contraints;
    }
}

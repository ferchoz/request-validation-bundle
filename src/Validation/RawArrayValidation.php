<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Validation;

final class RawArrayValidation implements RawValidationInferface
{
    public function __construct(private array $contraints)
    {
    }

    public function getRules(): array
    {
        return $this->contraints;
    }
}

<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Exception;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\ConstraintViolationList;

class RequestValidationException extends \RuntimeException
{
    private PropertyAccessor $propertyAccessor;
    private ConstraintViolationList $violations;

    public function __construct(ConstraintViolationList $violations)
    {
        $message = 'The given data failed to pass validation.';
        parent::__construct($message);

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->violations = $violations;
    }

    /**
     * @return array<mixed>
     */
    public function getResponseErrors(): array
    {
        $errors = [];
        $iterator = $this->violations->getIterator();

        foreach ($iterator as $violation) {
            $entryErrors = (array) $this->propertyAccessor->getValue($errors, $violation->getPropertyPath());
            $entryErrors[] = $violation->getMessage();

            $this->propertyAccessor->setValue($errors, $violation->getPropertyPath(), $entryErrors);
        }

        return $errors;
    }
}

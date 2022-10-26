<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Request;

use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Validator\Constraints\{Collection};
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\InvalidOptionsException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class BaseRequest extends BaseValidation {
    private const ALLOW_EXTRA_FIELDS = false;
    private const ALLOW_MISSING_FIELDS = false;
    private const EXTRA_FIELDS_MESSAGE = 'This field was not expected.';
    private const MISSING_FIELDS_MESSAGE = 'This field is missing.';

    /**
     * @return InputBag<string>
     */
    public function query(): InputBag {
        return $this->httpRequest->query;
    }

    /**
     * @return InputBag<bool|float|int|string>
     */
    public function request(): InputBag {
        return $this->httpRequest->request;
    }

    public function files(): FileBag {
        return $this->httpRequest->files;
    }

    /**
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     */
    public function rules(): Collection {
        return new Collection([
            'fields' => $this->getConstraints(),
            'allowExtraFields' => self::ALLOW_EXTRA_FIELDS,
            'allowMissingFields' => self::ALLOW_MISSING_FIELDS,
            'extraFieldsMessage' => self::EXTRA_FIELDS_MESSAGE,
            'missingFieldsMessage' => self::MISSING_FIELDS_MESSAGE,
        ]);
    }

    /**
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws ConstraintDefinitionException
     * @return array<string, \Symfony\Component\Validator\Constraint>
     */
    protected function getConstraints(): array {
        return [];
    }

}

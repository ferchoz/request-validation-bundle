<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Request;

use Choz\RequestValidationBundle\Exception\RequestValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseValidation
{
    protected Request $httpRequest;
    private ValidatorInterface $validator;

    final public function __construct(RequestStack $request)
    {
        $this->httpRequest = $request->getCurrentRequest() ?? new Request();
        $this->validator = Validation::createValidator();

        $this->validate();
    }

    /**
     * @return array<string, mixed>
     */
    final public function all(): array
    {
        return $this->httpRequest->query->all() + $this->httpRequest->request->all() + $this->httpRequest->files->all();
    }

    /** @return array<int,\Symfony\Component\Validator\Constraint> */
    abstract protected function rules(): array;

    final protected function validate(): bool
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($this->all(), $this->rules());

        if ($violations->count() !== 0) {
            throw new RequestValidationException($violations);
        }

        return true;
    }
}

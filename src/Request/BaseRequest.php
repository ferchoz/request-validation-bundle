<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Request;

use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\InputBag;

abstract class BaseRequest extends BaseValidation
{
    /**
     * @return InputBag<string>
     */
    public function query(): InputBag
    {
        return $this->httpRequest->query;
    }

    /**
     * @return InputBag<bool|float|int|string>
     */
    public function request(): InputBag
    {
        return $this->httpRequest->request;
    }

    public function files(): FileBag
    {
        return $this->httpRequest->files;
    }

    /** @return array<int,\Symfony\Component\Validator\Constraint> */
    abstract protected function rules(): array;
}

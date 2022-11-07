<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Request;

use Adbar\Dot;
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

    public function getFloat(string $path): float
    {
        return floatval($this->getAll()->get($path));
    }

    public function getFloatOrNull(string $path): ?float
    {
        $value = $this->getAll()->get($path);
        return null === $value ? null : floatval($value);
    }

    public function getInteger(string $path): int
    {
        return intval($this->getAll()->get($path));
    }

    public function getIntegerOrNull(string $path): ?int
    {
        $value = $this->getAll()->get($path);
        return null === $value ? null : intval($value);
    }

    public function getString(string $path): string
    {
        return strval($this->getAll()->get($path));
    }

    public function getStringOrNull(string $path): ?string
    {
        $value = $this->getAll()->get($path);
        return null === $value ? null : strval($value);
    }

    public function getBoolean(string $path): bool
    {
        $value = $this->getAll()->get($path);
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function getBooleanOrNull(string $path): ?bool
    {
        $value = $this->getAll()->get($path);
        return null === $value ? null : filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return array<mixed>
     */
    public function getArray(string $path): array
    {
        return (array) $this->getAll()->get($path);
    }

    /**
     * @return array<mixed>|null
     */
    public function getArrayOrNull(string $path): ?array
    {
        $value = $this->getAll()->get($path);
        return null === $value ? null : (array) $value;
    }

    /** @return array<int,\Symfony\Component\Validator\Constraint> */
    abstract protected function rules(): array;

    /**
     * @return Dot<int|string, mixed>
     */
    private function getAll(): Dot
    {
        return new Dot(array_merge($this->request()->all(), $this->query()->all()));
    }
}

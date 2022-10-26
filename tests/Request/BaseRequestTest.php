<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\Request;

use Choz\RequestValidationBundle\Exception\RequestValidationException;
use Choz\RequestValidationBundle\Tests\Request\Instances\ArrayOfScalarRequest;
use Choz\RequestValidationBundle\Tests\Request\Instances\ArrayOfStructuresRequest;
use Choz\RequestValidationBundle\Tests\Request\Instances\StructuresRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Throwable;

final class BaseRequestTest extends TestCase
{
    public function testArrayStringError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], ['1', '2', '3', '4', '5']));

        $this->expectException(RequestValidationException::class);

        new ArrayOfScalarRequest($requestStack);
    }

    public function testArrayEmptyError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->expectException(RequestValidationException::class);

        new ArrayOfScalarRequest($requestStack);
    }

    public function testArrayScalarSuccess(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], [1, 2, 3, 4, 5, 6]));
        $request = new ArrayOfScalarRequest($requestStack);
        $this->assertSame([1, 2, 3, 4, 5, 6], $request->all());
    }

    public function testArrayStructureError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], [['id' => 1, 'name' => 'first name'], ['id' => 1]]));

        $this->expectException(RequestValidationException::class);

        new ArrayOfStructuresRequest($requestStack);
    }

    public function testArrayStructureEmptyError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->expectException(RequestValidationException::class);

        new ArrayOfStructuresRequest($requestStack);
    }

    public function testArrayStructureSuccess(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], [['id' => 1, 'name' => 'first name'], ['id' => 2, 'name' => 'second name'], ['id' => 3, 'name' => 'third name']]));
        $request = new ArrayOfStructuresRequest($requestStack);
        $this->assertSame([['id' => 1, 'name' => 'first name'], ['id' => 2, 'name' => 'second name'], ['id' => 3, 'name' => 'third name']], $request->all());
    }

    public function testStructureError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], ['id' => 1]));

        $this->expectException(RequestValidationException::class);

        new StructuresRequest($requestStack);
    }

    public function testStructureEmptyError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->expectException(RequestValidationException::class);

        new StructuresRequest($requestStack);
    }

    public function testStructureSuccess(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], ['id' => 1, 'name' => 'first name']));
        try {

            $request = new StructuresRequest($requestStack);
        } catch (Throwable $t) {
            dd($t);
        }
        $this->assertSame(['id' => 1, 'name' => 'first name'], $request->all());
    }
}

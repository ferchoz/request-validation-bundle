<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\Request;

use Choz\RequestValidationBundle\Exception\RequestValidationException;
use Choz\RequestValidationBundle\Tests\Request\Instances\ArrayOfScalarRequest;
use Choz\RequestValidationBundle\Tests\Request\Instances\ArrayOfStructuresRequest;
use Choz\RequestValidationBundle\Tests\Request\Instances\StructuresRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class BaseRequestTest extends TestCase
{
    public function testArrayStringError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], ['1', '2', '3', '4', '5']));

        $this->expectException(RequestValidationException::class);

        $request = new ArrayOfScalarRequest($requestStack);
        $this->assertInstanceOf(ArrayOfScalarRequest::class, $request);
    }

    public function testArrayEmptyError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->expectException(RequestValidationException::class);

        $request = new ArrayOfScalarRequest($requestStack);
        $this->assertInstanceOf(ArrayOfScalarRequest::class, $request);
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
        $requestStack->push(new Request([], [['id' => 1, 'name' => 'lonely first name'], ['id' => 1]]));

        $this->expectException(RequestValidationException::class);

        $request = new ArrayOfStructuresRequest($requestStack);
        $this->assertInstanceOf(ArrayOfStructuresRequest::class, $request);
    }

    public function testArrayStructureEmptyError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->expectException(RequestValidationException::class);

        $request = new ArrayOfStructuresRequest($requestStack);
        $this->assertInstanceOf(ArrayOfStructuresRequest::class, $request);
    }

    public function testArrayStructureSuccess(): void
    {
        $requestStack = new RequestStack();
        $requestData = [
            ['id' => 1, 'name' => 'first name'],
            ['id' => 2, 'name' => 'second name'],
            ['id' => 3, 'name' => 'third name'],
        ];
        $requestStack->push(new Request([], $requestData));
        $request = new ArrayOfStructuresRequest($requestStack);
        $this->assertSame($requestData, $request->all());
    }

    public function testStructureError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], ['id' => 1]));

        $this->expectException(RequestValidationException::class);

        $request = new StructuresRequest($requestStack);
        $this->assertInstanceOf(StructuresRequest::class, $request);
    }

    public function testStructureEmptyError(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        $this->expectException(RequestValidationException::class);

        $request = new StructuresRequest($requestStack);
        $this->assertInstanceOf(StructuresRequest::class, $request);
    }

    public function testStructureSuccess(): void
    {
        $requestStack = new RequestStack();
        $requstData = ['id' => 1, 'name' => 'some name'];
        $requestStack->push(new Request([], $requstData));
        $request = new StructuresRequest($requestStack);

        $this->assertSame($requstData, $request->all());
    }

    public function testBaseRequestMethods(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request([], ['id' => 1, 'name' => 'lonely second name']));
        $request = new StructuresRequest($requestStack);

        $this->assertInstanceOf(InputBag::class, $request->request());
        $this->assertInstanceOf(InputBag::class, $request->query());
        $this->assertInstanceOf(FileBag::class, $request->files());
    }
}

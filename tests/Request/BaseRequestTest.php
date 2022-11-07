<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\Request;

use Choz\RequestValidationBundle\Exception\RequestValidationException;
use Choz\RequestValidationBundle\Tests\Request\Instances\ArrayOfScalarRequest;
use Choz\RequestValidationBundle\Tests\Request\Instances\ArrayOfStructuresRequest;
use Choz\RequestValidationBundle\Tests\Request\Instances\BaseRequestValueImplementationRequest;
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

    public function testFloatOrNull(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => 12.3], ['second_param' => ['sub_param' => '43.1']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals(12.3, $request->getFloatOrNull('first_param'));
        $this->assertEquals(43.1, $request->getFloatOrNull('second_param.sub_param'));
        $this->assertNull($request->getFloatOrNull('second_param.null'));
    }

    public function testIntegerOrNull(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => 12], ['second_param' => ['sub_param' => '43']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals(12, $request->getIntegerOrNull('first_param'));
        $this->assertEquals(43, $request->getIntegerOrNull('second_param.sub_param'));
        $this->assertNull($request->getIntegerOrNull('second_param.null'));
    }

    public function testStringOrNull(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => 'param1'], ['second_param' => ['sub_param' => 'param2']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals('param1', $request->getStringOrNull('first_param'));
        $this->assertEquals('param2', $request->getStringOrNull('second_param.sub_param'));
        $this->assertNull($request->getStringOrNull('second_param.null'));
    }

    public function testBooleanOrNull(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => true], ['second_param' => ['sub_param' => 'false']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertTrue($request->getBooleanOrNull('first_param'));
        $this->assertFalse($request->getBooleanOrNull('second_param.sub_param'));
        $this->assertNull($request->getBooleanOrNull('second_param.null'));
    }

    public function testArrayOrNull(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(
            new Request(['first_param' => ['one', 'two']], ['second_param' => ['sub_param' => ['three', 'four']]]),
        );
        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals(['one', 'two'], $request->getArrayOrNull('first_param'));
        $this->assertEquals(['three', 'four'], $request->getArrayOrNull('second_param.sub_param'));
        $this->assertNull($request->getBooleanOrNull('second_param.null'));
    }

    public function testFloat(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => 12.3], ['second_param' => ['sub_param' => '43.1']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals(12.3, $request->getFloat('first_param'));
        $this->assertEquals(43.1, $request->getFloat('second_param.sub_param'));
        $this->assertEquals(0.0, $request->getFloat('second_param.null'));
    }

    public function testInteger(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => 12], ['second_param' => ['sub_param' => '43']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals(12, $request->getInteger('first_param'));
        $this->assertEquals(43, $request->getInteger('second_param.sub_param'));
        $this->assertEquals(0, $request->getInteger('second_param.null'));
    }

    public function testString(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => 'param1'], ['second_param' => ['sub_param' => 'param2']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals('param1', $request->getString('first_param'));
        $this->assertEquals('param2', $request->getString('second_param.sub_param'));
        $this->assertEquals('', $request->getString('second_param.null'));
    }

    public function testBoolean(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(['first_param' => true], ['second_param' => ['sub_param' => 'false']]));

        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertTrue($request->getBoolean('first_param'));
        $this->assertFalse($request->getBoolean('second_param.sub_param'));
        $this->assertFalse($request->getBoolean('second_param.null'));
    }

    public function testArray(): void
    {
        $requestStack = new RequestStack();
        $requestStack->push(
            new Request(['first_param' => ['one', 'two']], ['second_param' => ['sub_param' => ['three', 'four']]]),
        );
        $request = new BaseRequestValueImplementationRequest($requestStack);

        $this->assertEquals(['one', 'two'], $request->getArray('first_param'));
        $this->assertEquals(['three', 'four'], $request->getArray('second_param.sub_param'));
        $this->assertEquals([], $request->getArray('second_param.null'));
    }
}

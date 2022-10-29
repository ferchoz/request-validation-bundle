<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\EventListener;

use Choz\RequestValidationBundle\EventListener\RequestValidationEventListener;
use Choz\RequestValidationBundle\Exception\RequestValidationException;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class RequestValidationEventListenerTest extends TestCase
{
    public function testHandleValidationRequestSuccessfully(): void
    {
        /** @var HttpKernelInterface $httpKernel */
        $httpKernel = $this->createMock(HttpKernelInterface::class);

        $someConstraintViolation = new ConstraintViolation('some violation', null, [], '', '[some_path]', '');
        $throws = new RequestValidationException(new ConstraintViolationList([$someConstraintViolation]));
        $exceptionEvent = new ExceptionEvent($httpKernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $throws);
        $listener = new RequestValidationEventListener();

        $this->assertNull($exceptionEvent->getResponse());
        $listener->onKernelException($exceptionEvent);

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $exceptionEvent->getResponse();

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame(
            '{"message":"The given data failed to pass validation.","errors":{"some_path":["some violation"]}}',
            $response->getContent(),
        );
    }

    public function testHandleNoException(): void
    {
        /** @var HttpKernelInterface */
        $httpKernel = $this->createMock(HttpKernelInterface::class);
        $throws = new Exception('random exception');
        $exceptionEvent = new ExceptionEvent($httpKernel, new Request(), HttpKernelInterface::MAIN_REQUEST, $throws);
        $listener = new RequestValidationEventListener();

        $this->assertNull($exceptionEvent->getResponse());
        $listener->onKernelException($exceptionEvent);
        $this->assertNull($exceptionEvent->getResponse());
    }
}

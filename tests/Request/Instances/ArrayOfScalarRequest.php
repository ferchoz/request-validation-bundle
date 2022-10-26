<?php

namespace Choz\RequestValidationBundle\Tests\Request\Instances;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Choz\RequestValidationBundle\Validation\RawArrayValidation;
use Choz\RequestValidationBundle\Validation\RawValidationInferface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Type;

class ArrayOfScalarRequest extends BaseRequest
{
    protected function getConstraints(): RawValidationInferface
    {
        return new RawArrayValidation([
            new All([
                new Type('int'),
            ]),
            new Count(['min' => 2]),
        ]);
    }
}

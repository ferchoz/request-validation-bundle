<?php

namespace Choz\RequestValidationBundle\Tests\Request\Instances;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Choz\RequestValidationBundle\Validation\RawStructureValidation;
use Choz\RequestValidationBundle\Validation\RawValidationInferface;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class StructuresRequest extends BaseRequest
{
    protected function getConstraints(): RawValidationInferface
    {
        return new RawStructureValidation([
            'id' => [new Required(), new Type('int')],
            'name' => [new Required(), new Type('string')],
        ]);
    }
}

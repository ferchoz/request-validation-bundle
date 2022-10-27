<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\Request\Instances;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Type;

class ArrayOfScalarRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            new All([
                new Type('int'),
            ]),
            new Count(['min' => 2]),
        ];
    }
}

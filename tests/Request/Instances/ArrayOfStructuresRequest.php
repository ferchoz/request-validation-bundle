<?php

namespace Choz\RequestValidationBundle\Tests\Request\Instances;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class ArrayOfStructuresRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            new All(
                [
                    new Collection([
                        'id' => [new Required(), new Type('int')],
                        'name' => [new Required(), new Type('string')],
                    ]),
                ]
            ),
            new Count(['min' => 2])
        ];
    }
}

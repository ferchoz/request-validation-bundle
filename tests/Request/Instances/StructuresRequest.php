<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\Request\Instances;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class StructuresRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            new Collection([
                'id' => [new Required(), new Type('int')],
                'name' => [new Required(), new Type('string')],
            ]),
        ];
    }
}

<?php

declare(strict_types=1);

namespace Choz\RequestValidationBundle\Tests\Request\Instances;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

class BaseRequestValueImplementationRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            new Collection([
                'first_param' => new Required([new NotBlank()]),
                'second_param' => new Collection([
                    'sub_param' => new Required([new NotBlank()]),
                ]),
            ]),
        ];
    }
}

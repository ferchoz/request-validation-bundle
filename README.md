# API Request Validation Bundle
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=ferchoz_request-validation-bundle&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=ferchoz_request-validation-bundle)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=ferchoz_request-validation-bundle&metric=coverage)](https://sonarcloud.io/summary/new_code?id=ferchoz_request-validation-bundle)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=ferchoz_request-validation-bundle&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=ferchoz_request-validation-bundle)

This is a small library that helps you validate incoming requests with the symfony validation component.
knowing how to work with the validation component is a must, [Validation doc](https://symfony.com/doc/current/validation/raw_values.html)

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require choz/request-validation-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require choz/request-validation-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Choz\RequestValidationBundle\ChozRequestValidationBundle::class => ['all' => true],
];
```

## Basic Usage

Request:
```php
<?php

declare(strict_types=1);

namespace App\Request;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class TagCreateRequest extends BaseRequest
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
```

Controller:
```php
<?php 

namespace App\Controller;

use App\Request\TagCreateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TagCreateController extends AbstractController
{
    #[Route('/tags', methods: ['POST'])]
    public function __invoke(TagCreateRequest $request): JsonResponse {
        $id = $request->request()->getInt('id');
        $name = $request->request()->getAlpha('name');
        // use your values
        return new JsonResponse(['id' => $id, 'name' => $name], status: JsonResponse::HTTP_CREATED);
    }
}
```

Response with errors from an empty request (code 400): 
```json
{
    "message": "The given data failed to pass validation.",
    "errors": {
        "id": [
            "This field is missing."
        ],
        "name": [
            "This field is missing."
        ]
    }
}
```

## Optional
To use it correctly with json request is recommended to install: [Symfony JsonRequest Bundle](https://github.com/symfony-bundles/json-request-bundle)

JSON Request: 
```json
{
    "id": "1234",
    "name": 123
}
```
Will get a JSON Response: 
```json
{
    "message": "The given data failed to pass validation.",
    "errors": {
        "id": [
            "This value should be of type int."
        ],
        "name": [
            "This value should be of type string."
        ]
    }
}
```

## Advanced (recommended) usage:


Request:
```php
<?php

declare(strict_types=1);

namespace App\Request;

use Choz\RequestValidationBundle\Request\BaseRequest;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;

class TagCreateRequest extends BaseRequest
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

    public function getId(): int {
        return $this->request()->getInt('id');
    }

    public function getName(): string {
        return $this->request()->getAlpha('name');
    }
}
```

Controller:
```php
<?php 

namespace App\Controller;

use App\Request\TagCreateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TagCreateController extends AbstractController
{
    #[Route('/tags', methods: ['POST'])]
    public function __invoke(TagCreateRequest $request): JsonResponse {
        $id = $request->getId();
        $name = $request->getName();
        // use your values
        return new JsonResponse(['id' => $id, 'name' => $name], status: JsonResponse::HTTP_CREATED);
    }
}
```

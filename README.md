# laravel-api-response

> Normalize and standardize Laravel API response data structures.

[![tests](https://github.com/guanguans/laravel-api-response/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-api-response/actions)
[![check & fix styling](https://github.com/guanguans/laravel-api-response/workflows/check%20&%20fix%20styling/badge.svg)](https://github.com/guanguans/laravel-api-response/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-api-response/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-api-response)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-api-response/v)](https://packagist.org/packages/guanguans/laravel-api-response)
[![GitHub release (with filter)](https://img.shields.io/github/v/release/guanguans/laravel-api-response)](https://github.com/guanguans/laravel-api-response/releases)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-api-response/downloads)](https://packagist.org/packages/guanguans/laravel-api-response)
[![License](https://poser.pugx.org/guanguans/laravel-api-response/license)](https://packagist.org/packages/guanguans/laravel-api-response)

## Features

* Support for customized response data structure
* Support for restful API response(optional)
* Support for automatically handled api exception
* Support for localized message
* Support for customized data pipe
* Support for customized exception pipe

## Requirement

* PHP >= 7.4

## Installation

```bash
composer require guanguans/laravel-api-response --ansi -v
```

## Configuration

### Publish files(optional)

```bash
php artisan vendor:publish --provider="Guanguans\\LaravelApiResponse\\ApiResponseServiceProvider" --ansi -v
```

## Usage

### Get Instance

<details>
<summary>details</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Guanguans\LaravelApiResponse\Facades\ApiResponseFacade;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function get()
    {
        /** @var \Guanguans\LaravelApiResponse\ApiResponse $apiResponse */
        $apiResponse = $this->apiResponse();
        $apiResponse = ApiResponseFacade::getFacadeRoot();
        $apiResponse = resolve(ApiResponseContract::class);
        $apiResponse = app(ApiResponseContract::class);
    }
}
```
</details>

### Default response structure

<details>
<summary>details</summary>

```json
{
    "status": "boolean",
    "code": "integer",
    "message": "string",
    "data": "mixed",
    "error": "object"
}
```
</details>

### Default response examples

<details>
<summary>model</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        $user = User::query()->with(['country', 'posts'])->first();

        return $this->apiResponse()->success($user);
    }
}
```

```json
{
    "status": true,
    "code": 200,
    "message": "OK",
    "data": {
        "id": 1,
        "name": "John",
        "country_id": 1,
        "created_at": "2024-01-01 00:00:01",
        "updated_at": "2024-01-01 00:00:01",
        "country": {
            "id": 1,
            "name": "China",
            "created_at": "2024-01-01 00:00:01",
            "updated_at": "2024-01-01 00:00:01"
        },
        "posts": [
            {
                "id": 1,
                "title": "PHP is the best language!",
                "user_id": 1,
                "created_at": "2024-01-01 00:00:01",
                "updated_at": "2024-01-01 00:00:01"
            },
            {
                "id": 2,
                "title": "JAVA is the best language!",
                "user_id": 1,
                "created_at": "2024-01-01 00:00:02",
                "updated_at": "2024-01-01 00:00:02"
            },
            {
                "id": 3,
                "title": "Python is the best language!",
                "user_id": 1,
                "created_at": "2024-01-01 00:00:03",
                "updated_at": "2024-01-01 00:00:03"
            }
        ]
    },
    "error": {}
}
```
</details>

<details>
<summary>eloquent collection</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        $users = User::query()->with(['country', 'posts'])->get();

        return $this->apiResponse()->success($users);
    }
}
```

```json
{
    "status": true,
    "code": 200,
    "message": "OK",
    "data": [
        {
            "id": 1,
            "name": "John",
            "country_id": 1,
            "created_at": "2024-01-01 00:00:01",
            "updated_at": "2024-01-01 00:00:01",
            "country": {
                "id": 1,
                "name": "China",
                "created_at": "2024-01-01 00:00:01",
                "updated_at": "2024-01-01 00:00:01"
            },
            "posts": [
                {
                    "id": 1,
                    "title": "PHP is the best language!",
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": "2024-01-01 00:00:01"
                },
                {
                    "id": 2,
                    "title": "JAVA is the best language!",
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": "2024-01-01 00:00:02"
                },
                {
                    "id": 3,
                    "title": "Python is the best language!",
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": "2024-01-01 00:00:03"
                }
            ]
        },
        {
            "id": 2,
            "name": "Tom",
            "country_id": 2,
            "created_at": "2024-01-01 00:00:02",
            "updated_at": "2024-01-01 00:00:02",
            "country": {
                "id": 2,
                "name": "USA",
                "created_at": "2024-01-01 00:00:02",
                "updated_at": "2024-01-01 00:00:02"
            },
            "posts": [
                {
                    "id": 4,
                    "title": "Go is the best language!",
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:04",
                    "updated_at": "2024-01-01 00:00:04"
                },
                {
                    "id": 5,
                    "title": "JavaScript is the best language!",
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:05",
                    "updated_at": "2024-01-01 00:00:05"
                },
                {
                    "id": 6,
                    "title": "Ruby is the best language!",
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:06",
                    "updated_at": "2024-01-01 00:00:06"
                }
            ]
        },
        {
            "id": 3,
            "name": "Jerry",
            "country_id": 3,
            "created_at": "2024-01-01 00:00:03",
            "updated_at": "2024-01-01 00:00:03",
            "country": {
                "id": 3,
                "name": "Japan",
                "created_at": "2024-01-01 00:00:03",
                "updated_at": "2024-01-01 00:00:03"
            },
            "posts": [
                {
                    "id": 7,
                    "title": "C is the best language!",
                    "user_id": 3,
                    "created_at": "2024-01-01 00:00:07",
                    "updated_at": "2024-01-01 00:00:07"
                }
            ]
        },
        {
            "id": 4,
            "name": "Jack",
            "country_id": 4,
            "created_at": "2024-01-01 00:00:04",
            "updated_at": "2024-01-01 00:00:04",
            "country": {
                "id": 4,
                "name": "Korea",
                "created_at": "2024-01-01 00:00:04",
                "updated_at": "2024-01-01 00:00:04"
            },
            "posts": []
        },
        {
            "id": 5,
            "name": "Rose",
            "country_id": 5,
            "created_at": "2024-01-01 00:00:05",
            "updated_at": "2024-01-01 00:00:05",
            "country": {
                "id": 5,
                "name": "UK",
                "created_at": "2024-01-01 00:00:05",
                "updated_at": "2024-01-01 00:00:05"
            },
            "posts": []
        },
        {
            "id": 6,
            "name": "Lucy",
            "country_id": 6,
            "created_at": "2024-01-01 00:00:06",
            "updated_at": "2024-01-01 00:00:06",
            "country": {
                "id": 6,
                "name": "France",
                "created_at": "2024-01-01 00:00:06",
                "updated_at": "2024-01-01 00:00:06"
            },
            "posts": []
        },
        {
            "id": 7,
            "name": "Lily",
            "country_id": 7,
            "created_at": "2024-01-01 00:00:07",
            "updated_at": "2024-01-01 00:00:07",
            "country": {
                "id": 7,
                "name": "Germany",
                "created_at": "2024-01-01 00:00:07",
                "updated_at": "2024-01-01 00:00:07"
            },
            "posts": []
        }
    ],
    "error": {}
}
```
</details>

<details>
<summary>simple paginate</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        $simplePaginate = User::query()->with(['country', 'posts'])->simplePaginate(3);

        return $this->apiResponse()->success($simplePaginate);
    }
}
```

```json
{
    "status": true,
    "code": 200,
    "message": "OK",
    "data": {
        "data": [
            {
                "id": 1,
                "name": "John",
                "country_id": 1,
                "created_at": "2024-01-01 00:00:01",
                "updated_at": "2024-01-01 00:00:01",
                "country": {
                    "id": 1,
                    "name": "China",
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": "2024-01-01 00:00:01"
                },
                "posts": [
                    {
                        "id": 1,
                        "title": "PHP is the best language!",
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:01",
                        "updated_at": "2024-01-01 00:00:01"
                    },
                    {
                        "id": 2,
                        "title": "JAVA is the best language!",
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:02",
                        "updated_at": "2024-01-01 00:00:02"
                    },
                    {
                        "id": 3,
                        "title": "Python is the best language!",
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:03",
                        "updated_at": "2024-01-01 00:00:03"
                    }
                ]
            },
            {
                "id": 2,
                "name": "Tom",
                "country_id": 2,
                "created_at": "2024-01-01 00:00:02",
                "updated_at": "2024-01-01 00:00:02",
                "country": {
                    "id": 2,
                    "name": "USA",
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": "2024-01-01 00:00:02"
                },
                "posts": [
                    {
                        "id": 4,
                        "title": "Go is the best language!",
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:04",
                        "updated_at": "2024-01-01 00:00:04"
                    },
                    {
                        "id": 5,
                        "title": "JavaScript is the best language!",
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:05",
                        "updated_at": "2024-01-01 00:00:05"
                    },
                    {
                        "id": 6,
                        "title": "Ruby is the best language!",
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:06",
                        "updated_at": "2024-01-01 00:00:06"
                    }
                ]
            },
            {
                "id": 3,
                "name": "Jerry",
                "country_id": 3,
                "created_at": "2024-01-01 00:00:03",
                "updated_at": "2024-01-01 00:00:03",
                "country": {
                    "id": 3,
                    "name": "Japan",
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": "2024-01-01 00:00:03"
                },
                "posts": [
                    {
                        "id": 7,
                        "title": "C is the best language!",
                        "user_id": 3,
                        "created_at": "2024-01-01 00:00:07",
                        "updated_at": "2024-01-01 00:00:07"
                    }
                ]
            }
        ],
        "links": {
            "first": "http:\/\/localhost?page=1",
            "last": null,
            "prev": null,
            "next": "http:\/\/localhost?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "path": "http:\/\/localhost",
            "per_page": 3,
            "to": 3
        }
    },
    "error": {}
}
```
</details>

<details>
<summary>resource</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Guanguans\LaravelApiResponse\Tests\Laravel\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        $userResource = UserResource::make(User::query()->with(['country', 'posts'])->first());

        return $this->apiResponse()->success($userResource);
    }
}
```

```json
{
    "status": true,
    "code": 200,
    "message": "OK",
    "data": {
        "data": {
            "id": 1,
            "name": "John",
            "country_id": 1,
            "created_at": "2024-01-01 00:00:01",
            "updated_at": "2024-01-01 00:00:01",
            "country": {
                "id": 1,
                "name": "China",
                "created_at": "2024-01-01 00:00:01",
                "updated_at": "2024-01-01 00:00:01"
            },
            "posts": [
                {
                    "id": 1,
                    "title": "PHP is the best language!",
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": "2024-01-01 00:00:01"
                },
                {
                    "id": 2,
                    "title": "JAVA is the best language!",
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": "2024-01-01 00:00:02"
                },
                {
                    "id": 3,
                    "title": "Python is the best language!",
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": "2024-01-01 00:00:03"
                }
            ]
        }
    },
    "error": {}
}
```
</details>

<details>
<summary>resource collection</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Guanguans\LaravelApiResponse\Tests\Laravel\Resources\UserCollection;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        $userCollection = UserCollection::make(User::query()->with(['country', 'posts'])->get());

        return $this->apiResponse()->success($userCollection);
    }
}
```

```json
{
    "status": true,
    "code": 200,
    "message": "OK",
    "data": {
        "data": [
            {
                "id": 1,
                "name": "John",
                "country_id": 1,
                "created_at": "2024-01-01 00:00:01",
                "updated_at": "2024-01-01 00:00:01",
                "country": {
                    "id": 1,
                    "name": "China",
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": "2024-01-01 00:00:01"
                },
                "posts": [
                    {
                        "id": 1,
                        "title": "PHP is the best language!",
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:01",
                        "updated_at": "2024-01-01 00:00:01"
                    },
                    {
                        "id": 2,
                        "title": "JAVA is the best language!",
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:02",
                        "updated_at": "2024-01-01 00:00:02"
                    },
                    {
                        "id": 3,
                        "title": "Python is the best language!",
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:03",
                        "updated_at": "2024-01-01 00:00:03"
                    }
                ]
            },
            {
                "id": 2,
                "name": "Tom",
                "country_id": 2,
                "created_at": "2024-01-01 00:00:02",
                "updated_at": "2024-01-01 00:00:02",
                "country": {
                    "id": 2,
                    "name": "USA",
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": "2024-01-01 00:00:02"
                },
                "posts": [
                    {
                        "id": 4,
                        "title": "Go is the best language!",
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:04",
                        "updated_at": "2024-01-01 00:00:04"
                    },
                    {
                        "id": 5,
                        "title": "JavaScript is the best language!",
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:05",
                        "updated_at": "2024-01-01 00:00:05"
                    },
                    {
                        "id": 6,
                        "title": "Ruby is the best language!",
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:06",
                        "updated_at": "2024-01-01 00:00:06"
                    }
                ]
            },
            {
                "id": 3,
                "name": "Jerry",
                "country_id": 3,
                "created_at": "2024-01-01 00:00:03",
                "updated_at": "2024-01-01 00:00:03",
                "country": {
                    "id": 3,
                    "name": "Japan",
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": "2024-01-01 00:00:03"
                },
                "posts": [
                    {
                        "id": 7,
                        "title": "C is the best language!",
                        "user_id": 3,
                        "created_at": "2024-01-01 00:00:07",
                        "updated_at": "2024-01-01 00:00:07"
                    }
                ]
            },
            {
                "id": 4,
                "name": "Jack",
                "country_id": 4,
                "created_at": "2024-01-01 00:00:04",
                "updated_at": "2024-01-01 00:00:04",
                "country": {
                    "id": 4,
                    "name": "Korea",
                    "created_at": "2024-01-01 00:00:04",
                    "updated_at": "2024-01-01 00:00:04"
                },
                "posts": []
            },
            {
                "id": 5,
                "name": "Rose",
                "country_id": 5,
                "created_at": "2024-01-01 00:00:05",
                "updated_at": "2024-01-01 00:00:05",
                "country": {
                    "id": 5,
                    "name": "UK",
                    "created_at": "2024-01-01 00:00:05",
                    "updated_at": "2024-01-01 00:00:05"
                },
                "posts": []
            },
            {
                "id": 6,
                "name": "Lucy",
                "country_id": 6,
                "created_at": "2024-01-01 00:00:06",
                "updated_at": "2024-01-01 00:00:06",
                "country": {
                    "id": 6,
                    "name": "France",
                    "created_at": "2024-01-01 00:00:06",
                    "updated_at": "2024-01-01 00:00:06"
                },
                "posts": []
            },
            {
                "id": 7,
                "name": "Lily",
                "country_id": 7,
                "created_at": "2024-01-01 00:00:07",
                "updated_at": "2024-01-01 00:00:07",
                "country": {
                    "id": 7,
                    "name": "Germany",
                    "created_at": "2024-01-01 00:00:07",
                    "updated_at": "2024-01-01 00:00:07"
                },
                "posts": []
            }
        ]
    },
    "error": {}
}
```
</details>

<details>
<summary>error</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        return $this->apiResponse()->error('This is an error.');
    }
}
```

```json
{
    "status": false,
    "code": 400,
    "message": "This is an error.",
    "data": {},
    "error": {}
}
```
</details>

<details>
<summary>exception</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        config()->set('app.debug', false);
        $runtimeException = new \RuntimeException('This is a runtime exception.');

        return $this->apiResponse()->exception($runtimeException);
    }
}
```

```json
{
    "status": false,
    "code": 500,
    "message": "Internal Server Error",
    "data": {},
    "error": {
        "message": "Server Error"
    }
}
```
</details>

<details>
<summary>debug exception</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        config()->set('app.debug', true);
        $runtimeException = new \RuntimeException('This is a runtime exception.');

        return $this->apiResponse()->exception($runtimeException);
    }
}
```

```json
{
    "status": false,
    "code": 500,
    "message": "This is a runtime exception.",
    "data": {},
    "error": {
        "message": "This is a runtime exception.",
        "exception": "RuntimeException",
        "file": "\/tests\/Feature\/ExceptionDataTypesTest.php",
        "line": 45,
        "trace": [
            {
                "function": "{closure}",
                "class": "P\\Tests\\Feature\\ExceptionDataTypesTest",
                "type": "->"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/src\/Factories\/TestCaseFactory.php",
                "line": 151,
                "function": "call_user_func"
            },
            {
                "function": "Pest\\Factories\\{closure}",
                "class": "P\\Tests\\Feature\\ExceptionDataTypesTest",
                "type": "->"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/src\/Concerns\/Testable.php",
                "line": 301,
                "function": "call_user_func_array"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/src\/Support\/ExceptionTrace.php",
                "line": 29,
                "function": "Pest\\Concerns\\{closure}",
                "class": "P\\Tests\\Feature\\ExceptionDataTypesTest",
                "type": "->"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/src\/Concerns\/Testable.php",
                "line": 302,
                "function": "ensure",
                "class": "Pest\\Support\\ExceptionTrace",
                "type": "::"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/src\/Concerns\/Testable.php",
                "line": 278,
                "function": "__callClosure",
                "class": "P\\Tests\\Feature\\ExceptionDataTypesTest",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/Framework\/TestCase.php",
                "line": 1617,
                "function": "__test",
                "class": "P\\Tests\\Feature\\ExceptionDataTypesTest",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/Framework\/TestCase.php",
                "line": 1223,
                "function": "runTest",
                "class": "PHPUnit\\Framework\\TestCase",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/Framework\/TestResult.php",
                "line": 729,
                "function": "runBare",
                "class": "PHPUnit\\Framework\\TestCase",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/Framework\/TestCase.php",
                "line": 973,
                "function": "run",
                "class": "PHPUnit\\Framework\\TestResult",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/Framework\/TestSuite.php",
                "line": 685,
                "function": "run",
                "class": "PHPUnit\\Framework\\TestCase",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/Framework\/TestSuite.php",
                "line": 685,
                "function": "run",
                "class": "PHPUnit\\Framework\\TestSuite",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/TextUI\/TestRunner.php",
                "line": 651,
                "function": "run",
                "class": "PHPUnit\\Framework\\TestSuite",
                "type": "->"
            },
            {
                "file": "\/vendor\/phpunit\/phpunit\/src\/TextUI\/Command.php",
                "line": 146,
                "function": "run",
                "class": "PHPUnit\\TextUI\\TestRunner",
                "type": "->"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/src\/Console\/Command.php",
                "line": 119,
                "function": "run",
                "class": "PHPUnit\\TextUI\\Command",
                "type": "->"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/bin\/pest",
                "line": 61,
                "function": "run",
                "class": "Pest\\Console\\Command",
                "type": "->"
            },
            {
                "file": "\/vendor\/pestphp\/pest\/bin\/pest",
                "line": 62,
                "function": "{closure}"
            },
            {
                "file": "\/vendor\/bin\/pest",
                "line": 115,
                "function": "include"
            }
        ]
    }
}
```
</details>

<details>
<summary>exception handler</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        config()->set('app.debug', false);

        throw new \RuntimeException('This is a runtime exception.');
    }
}
```

```json
{
    "status": false,
    "code": 500,
    "message": "Internal Server Error",
    "data": {},
    "error": {
        "message": "Server Error"
    }
}
```
</details>

<details>
<summary>locale exception</summary>

```php
<?php

namespace App\Http\Controllers\Api;

use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        config()->set('app.debug', false);
        config()->set('app.locale', 'zh_CN');
        $runtimeException = new \RuntimeException('This is a runtime exception.');

        return $this->apiResponse()->exception($runtimeException);
    }
}
```

```json
{
    "status": false,
    "code": 500,
    "message": "内部服务器错误",
    "data": {},
    "error": {
        "message": "Server Error"
    }
}
```
</details>

<details>
<summary>more examples...</summary>

* [feature](tests/Feature)
* [examples](tests/__snapshots__)
</details>

### Methods of http status

[ConcreteHttpStatus.php](src/Concerns/ConcreteHttpStatus.php)

### Configuration

<details>
<summary>Render using</summary>


</details>

<details>
<summary>Exception pipes</summary>


</details>

<details>
<summary>Pipes</summary>


</details>

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## Thanks

[![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/guanguans)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

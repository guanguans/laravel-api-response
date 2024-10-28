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
* Support for automatically handled exception
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
        $apiResponse = $this->apiResponse(); //
        $apiResponse = ApiResponseFacade::getFacadeRoot();
        $apiResponse = resolve(ApiResponseContract::class);
        $apiResponse = app(ApiResponseContract::class);
    }
}
```

### Response examples

<details>
<summary><b>Model data</b></summary>

```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        return $this->apiResponse()->success(
            User::query()->with('posts')->first()
        );
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
        "country_id": 1,
        "posts": [
            {
                "id": 3,
                "user_id": 1,
                "created_at": "2024-01-01 00:00:03",
                "updated_at": null
            },
            {
                "id": 2,
                "user_id": 1,
                "created_at": "2024-01-01 00:00:02",
                "updated_at": null
            },
            {
                "id": 1,
                "user_id": 1,
                "created_at": "2024-01-01 00:00:01",
                "updated_at": null
            }
        ]
    },
    "error": {}
}
```
</details>

<details>
<summary><b>Collection data</b></summary>


```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        return $this->apiResponse()->success(
            User::query()->with(['posts', 'roles'])->get()
        );
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
            "country_id": 1,
            "posts": [
                {
                    "id": 3,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": null
                },
                {
                    "id": 2,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": null
                },
                {
                    "id": 1,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": null
                }
            ],
            "roles": [
                {
                    "id": 3,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 3
                    }
                },
                {
                    "id": 2,
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 2
                    }
                },
                {
                    "id": 1,
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 1
                    }
                }
            ]
        },
        {
            "id": 2,
            "country_id": 2,
            "posts": [
                {
                    "id": 6,
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:06",
                    "updated_at": null
                },
                {
                    "id": 5,
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:05",
                    "updated_at": null
                },
                {
                    "id": 4,
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:04",
                    "updated_at": null
                }
            ],
            "roles": [
                {
                    "id": 6,
                    "created_at": "2024-01-01 00:00:06",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 2,
                        "role_id": 6
                    }
                },
                {
                    "id": 5,
                    "created_at": "2024-01-01 00:00:05",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 2,
                        "role_id": 5
                    }
                },
                {
                    "id": 4,
                    "created_at": "2024-01-01 00:00:04",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 2,
                        "role_id": 4
                    }
                }
            ]
        },
        {
            "id": 3,
            "country_id": 3,
            "posts": [
                {
                    "id": 7,
                    "user_id": 3,
                    "created_at": "2024-01-01 00:00:07",
                    "updated_at": null
                }
            ],
            "roles": [
                {
                    "id": 7,
                    "created_at": "2024-01-01 00:00:07",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 3,
                        "role_id": 7
                    }
                }
            ]
        },
        {
            "id": 4,
            "country_id": 4,
            "posts": [],
            "roles": []
        },
        {
            "id": 5,
            "country_id": 5,
            "posts": [],
            "roles": []
        },
        {
            "id": 6,
            "country_id": 6,
            "posts": [],
            "roles": []
        },
        {
            "id": 7,
            "country_id": 7,
            "posts": [],
            "roles": []
        }
    ],
    "error": {}
}
```
</details>

<details>
<summary><b>Paginate data</b></summary>

```php
<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        return $this->apiResponse()->success(
            User::query()->with(['posts', 'roles'])->paginate(3)
        );
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
                "country_id": 1,
                "posts": [
                    {
                        "id": 3,
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:03",
                        "updated_at": null
                    },
                    {
                        "id": 2,
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:02",
                        "updated_at": null
                    },
                    {
                        "id": 1,
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:01",
                        "updated_at": null
                    }
                ],
                "roles": [
                    {
                        "id": 3,
                        "created_at": "2024-01-01 00:00:03",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 1,
                            "role_id": 3
                        }
                    },
                    {
                        "id": 2,
                        "created_at": "2024-01-01 00:00:02",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 1,
                            "role_id": 2
                        }
                    },
                    {
                        "id": 1,
                        "created_at": "2024-01-01 00:00:01",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 1,
                            "role_id": 1
                        }
                    }
                ]
            },
            {
                "id": 2,
                "country_id": 2,
                "posts": [
                    {
                        "id": 6,
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:06",
                        "updated_at": null
                    },
                    {
                        "id": 5,
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:05",
                        "updated_at": null
                    },
                    {
                        "id": 4,
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:04",
                        "updated_at": null
                    }
                ],
                "roles": [
                    {
                        "id": 6,
                        "created_at": "2024-01-01 00:00:06",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 2,
                            "role_id": 6
                        }
                    },
                    {
                        "id": 5,
                        "created_at": "2024-01-01 00:00:05",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 2,
                            "role_id": 5
                        }
                    },
                    {
                        "id": 4,
                        "created_at": "2024-01-01 00:00:04",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 2,
                            "role_id": 4
                        }
                    }
                ]
            },
            {
                "id": 3,
                "country_id": 3,
                "posts": [
                    {
                        "id": 7,
                        "user_id": 3,
                        "created_at": "2024-01-01 00:00:07",
                        "updated_at": null
                    }
                ],
                "roles": [
                    {
                        "id": 7,
                        "created_at": "2024-01-01 00:00:07",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 3,
                            "role_id": 7
                        }
                    }
                ]
            }
        ],
        "links": {
            "first": "http:\/\/localhost?page=1",
            "last": "http:\/\/localhost?page=3",
            "prev": null,
            "next": "http:\/\/localhost?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 3,
            "links": [
                {
                    "url": null,
                    "label": "pagination.previous",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": "http:\/\/localhost?page=2",
                    "label": "2",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost?page=3",
                    "label": "3",
                    "active": false
                },
                {
                    "url": "http:\/\/localhost?page=2",
                    "label": "pagination.next",
                    "active": false
                }
            ],
            "path": "http:\/\/localhost",
            "per_page": 3,
            "to": 3,
            "total": 7
        }
    },
    "error": {}
}
```
</details>

<details>
<summary><b>Resource data</b></summary>

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        return $this->apiResponse()->success(
            UserResource::make(User::query()->with('posts')->first())
        );
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
            "country_id": 1,
            "post": {
                "id": 3,
                "user_id": 1,
                "created_at": "2024-01-01 00:00:03",
                "updated_at": null
            },
            "posts": [
                {
                    "id": 3,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": null
                },
                {
                    "id": 2,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": null
                },
                {
                    "id": 1,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": null
                }
            ],
            "roles": [
                {
                    "id": 3,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 3
                    }
                },
                {
                    "id": 2,
                    "created_at": "2024-01-01 00:00:02",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 2
                    }
                },
                {
                    "id": 1,
                    "created_at": "2024-01-01 00:00:01",
                    "updated_at": null,
                    "pivot": {
                        "user_id": 1,
                        "role_id": 1
                    }
                }
            ]
        }
    },
    "error": {}
}
```
</details>

<details>
<summary><b>ResourceCollection data</b></summary>

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Http\JsonResponse;

class Controller extends \App\Http\Controllers\Controller
{
    use ApiResponseFactory;

    public function example(): JsonResponse
    {
        return $this->apiResponse()->success(
            UserCollection::make(User::query()->with(['posts', 'roles'])->get()),
        );
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
                "country_id": 1,
                "post": {
                    "id": 3,
                    "user_id": 1,
                    "created_at": "2024-01-01 00:00:03",
                    "updated_at": null
                },
                "posts": [
                    {
                        "id": 3,
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:03",
                        "updated_at": null
                    },
                    {
                        "id": 2,
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:02",
                        "updated_at": null
                    },
                    {
                        "id": 1,
                        "user_id": 1,
                        "created_at": "2024-01-01 00:00:01",
                        "updated_at": null
                    }
                ],
                "roles": [
                    {
                        "id": 3,
                        "created_at": "2024-01-01 00:00:03",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 1,
                            "role_id": 3
                        }
                    },
                    {
                        "id": 2,
                        "created_at": "2024-01-01 00:00:02",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 1,
                            "role_id": 2
                        }
                    },
                    {
                        "id": 1,
                        "created_at": "2024-01-01 00:00:01",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 1,
                            "role_id": 1
                        }
                    }
                ]
            },
            {
                "id": 2,
                "country_id": 2,
                "post": {
                    "id": 6,
                    "user_id": 2,
                    "created_at": "2024-01-01 00:00:06",
                    "updated_at": null
                },
                "posts": [
                    {
                        "id": 6,
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:06",
                        "updated_at": null
                    },
                    {
                        "id": 5,
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:05",
                        "updated_at": null
                    },
                    {
                        "id": 4,
                        "user_id": 2,
                        "created_at": "2024-01-01 00:00:04",
                        "updated_at": null
                    }
                ],
                "roles": [
                    {
                        "id": 6,
                        "created_at": "2024-01-01 00:00:06",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 2,
                            "role_id": 6
                        }
                    },
                    {
                        "id": 5,
                        "created_at": "2024-01-01 00:00:05",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 2,
                            "role_id": 5
                        }
                    },
                    {
                        "id": 4,
                        "created_at": "2024-01-01 00:00:04",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 2,
                            "role_id": 4
                        }
                    }
                ]
            },
            {
                "id": 3,
                "country_id": 3,
                "post": {
                    "id": 7,
                    "user_id": 3,
                    "created_at": "2024-01-01 00:00:07",
                    "updated_at": null
                },
                "posts": [
                    {
                        "id": 7,
                        "user_id": 3,
                        "created_at": "2024-01-01 00:00:07",
                        "updated_at": null
                    }
                ],
                "roles": [
                    {
                        "id": 7,
                        "created_at": "2024-01-01 00:00:07",
                        "updated_at": null,
                        "pivot": {
                            "user_id": 3,
                            "role_id": 7
                        }
                    }
                ]
            },
            {
                "id": 4,
                "country_id": 4,
                "post": null,
                "posts": [],
                "roles": []
            },
            {
                "id": 5,
                "country_id": 5,
                "post": null,
                "posts": [],
                "roles": []
            },
            {
                "id": 6,
                "country_id": 6,
                "post": null,
                "posts": [],
                "roles": []
            },
            {
                "id": 7,
                "country_id": 7,
                "post": null,
                "posts": [],
                "roles": []
            }
        ]
    },
    "error": {}
}
```
</details>

[More examples...](tests/__snapshots__)

### Methods of http status

[ConcreteHttpStatus.php](src/Concerns/ConcreteHttpStatus.php)

### Status Code Pipe

### Render using

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

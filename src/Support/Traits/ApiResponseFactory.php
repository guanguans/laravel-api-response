<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Support\Traits;

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;

trait ApiResponseFactory
{
    /**
     * @noinspection PhpDocSignatureInspection
     *
     * @return \Guanguans\LaravelApiResponse\ApiResponse|\Guanguans\LaravelApiResponse\Contracts\ApiResponseContract
     */
    public function apiResponse(): ApiResponseContract
    {
        return app(ApiResponseContract::class);
    }
}

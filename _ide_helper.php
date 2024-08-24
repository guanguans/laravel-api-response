<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace {
    class ApiResponseFacade extends Guanguans\LaravelApiResponse\Facades\ApiResponseFacade {}
}

namespace Illuminate\Support {
    /**
     * @method self unshift(...$values)
     *
     * @see \Guanguans\LaravelApiResponse\Support\Macros\CollectionMacro
     */
    class Collection {}
}

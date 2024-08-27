<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\ApiResponse;
use Illuminate\Support\Collection;

it('can use exception pipes', function (): void {
    expect($this->apiResponse())
        ->unshiftExceptionPipes()->toBeInstanceOf(ApiResponse::class)
        ->pushExceptionPipes()->toBeInstanceOf(ApiResponse::class)
        ->extendExceptionPipes(fn (Collection $pipes): Collection => $pipes)->toBeInstanceOf(ApiResponse::class);
})->group(__DIR__, __FILE__);

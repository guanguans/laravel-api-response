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

use Illuminate\Http\JsonResponse;

it('can return a JsonResponse', function (): void {
    expect(\Guanguans\LaravelApiResponse\Facades\ApiResponse::success())->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);

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

it('can return JsonResponse', function (): void {
    expect($this->apiResponse()->exception(new \RuntimeException('foo')))
        ->toBeInstanceOf(JsonResponse::class)
        ->isServerError()->toBeTrue();
})->group(__DIR__, __FILE__);

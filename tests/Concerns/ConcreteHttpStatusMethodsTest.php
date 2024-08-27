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
use Pest\Expectation;

it('can use http status methods', function (): void {
    expect([
        'ok',
        'created',
        'accepted',
        'localize',
        'noContent',

        'badRequest',
        'unauthorized',
        'paymentRequired',
        'forbidden',
        'notFound',
        'methodNotAllowed',
        'requestTimeout',
        'conflict',
        'teapot',
        'unprocessableEntity',
        'tooManyRequests',
    ])->each(function (Expectation $expectation): void {
        expect($this->apiResponse()->{$expectation->value}())
            ->toBeInstanceOf(JsonResponse::class)
            ->isOK()->toBeTrue();
    });
})->group(__DIR__, __FILE__);

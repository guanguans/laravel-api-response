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

use Symfony\Component\HttpFoundation\Response;

it('can return exception error json response', function (): void {
    $this
        ->post('exception')
        ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

    $this
        ->post('api/exception')
        ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
})->group(__DIR__, __FILE__);

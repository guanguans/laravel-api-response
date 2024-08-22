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

it('can return success json response', function (): void {
    $this
        ->post('success', [
            'foo' => 'bar',
            'bar' => 'baz',
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can return error json response', function (): void {
    $this
        ->post('error')
        ->assertOk();
})->group(__DIR__, __FILE__);

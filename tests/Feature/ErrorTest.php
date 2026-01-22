<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {});

it('is error', function (string $language): void {
    config()->set('app.locale', $language);
    assertMatchesJsonSnapshot($this->apiResponse()->error('This is an error.')->content());
})->group(__DIR__, __FILE__)->with('languages');

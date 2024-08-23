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

use function Spatie\Snapshots\assertMatchesJsonSnapshot;

it('can return Model type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(null)->content());
})->group(__DIR__, __FILE__)->skip('To do ...');

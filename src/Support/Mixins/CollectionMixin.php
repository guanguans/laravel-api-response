<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Support\Mixins;

/**
 * @api
 *
 * @property array<array-key, mixed> $items
 *
 * @mixin \Illuminate\Support\Collection<array-key, mixed>
 */
class CollectionMixin
{
    public function unshift(): \Closure
    {
        return function (mixed ...$values): self {
            array_unshift($this->items, ...$values);

            return $this;
        };
    }
}

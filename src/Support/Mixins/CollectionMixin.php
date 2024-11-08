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

namespace Guanguans\LaravelApiResponse\Support\Mixins;

/**
 * @property array $items
 *
 * @mixin  \Illuminate\Support\Collection
 */
class CollectionMixin
{
    public function unshift(): \Closure
    {
        return function (...$values): self {
            array_unshift($this->items, ...$values);

            return $this;
        };
    }
}

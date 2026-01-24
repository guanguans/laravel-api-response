<?php

/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpIllegalPsrClassPathInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Illuminate\Support\Traits;

if (trait_exists(Dumpable::class)) {
    return;
}

/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/Traits/Dumpable.php
 */
trait Dumpable
{
    /**
     * Dump the given arguments and terminate execution.
     */
    public function dd(mixed ...$args): void
    {
        dd($this, ...$args); // @codeCoverageIgnore
    }

    /**
     * Dump the given arguments.
     */
    public function dump(mixed ...$args): self
    {
        dump($this, ...$args);

        return $this;
    }
}

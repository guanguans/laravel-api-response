<?php

/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\RenderUsings;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

/**
 * @method bool shouldReturnJson(\Illuminate\Http\Request $request, \Throwable $throwable)
 */
class ShouldReturnJsonRenderUsing extends RenderUsing
{
    protected function when(Request $request, \Throwable $throwable): bool
    {
        return (fn (): bool => $this->shouldReturnJson($request, $throwable))->call(app(ExceptionHandler::class));
    }
}

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

namespace Guanguans\LaravelApiResponse\RenderUsingFactories;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

class ShouldReturnJsonRenderUsingFactory extends RenderUsingFactory
{
    public function when(Request $request, \Throwable $throwable, ExceptionHandler $exceptionHandler): bool
    {
        return (fn (): bool => $this->shouldReturnJson($request, $throwable))->call($exceptionHandler);
    }
}

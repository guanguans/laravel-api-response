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

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

/**
 * @property \Illuminate\Contracts\Container\Container $container
 *
 * @method bool shouldReturnJson(\Illuminate\Http\Request $request, \Throwable $throwable)
 *
 * @mixin \Illuminate\Foundation\Exceptions\Handler
 */
abstract class RenderUsingFactory
{
    /**
     * @noinspection StaticClosureCanBeUsedInspection
     * @noinspection AnonymousFunctionStaticInspection
     * @noinspection PhpInconsistentReturnPointsInspection
     *
     * @see \Guanguans\LaravelApiResponse\ApiResponseServiceProvider::registerRenderUsing()
     */
    public function __invoke(ExceptionHandler $exceptionHandler): \Closure
    {
        /**
         * @return \Illuminate\Http\JsonResponse|void
         */
        return function (\Throwable $throwable, Request $request) {
            try {
                if ($this->when($request, $throwable)) {
                    return app(ApiResponseContract::class)->throw($throwable);
                }
            } catch (\Throwable $throwable) {
                // If catch an exception, only report it,
                // and to let the default exception handler handle original exception.
                report($throwable);
            }
        };
    }

    abstract protected function when(Request $request, \Throwable $throwable): bool;
}
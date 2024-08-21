<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

/**
 * @property \Illuminate\Contracts\Container\Container $container
 *
 * @method shouldReturnJson(\Illuminate\Http\Request $request, \Throwable $throwable)
 *
 * @mixin \Illuminate\Foundation\Exceptions\Handler
 */
class RenderUsingFactory
{
    /**
     * @noinspection StaticClosureCanBeUsedInspection
     * @noinspection AnonymousFunctionStaticInspection
     * @noinspection PhpInconsistentReturnPointsInspection
     *
     * @psalm-suppress UndefinedThisPropertyFetch
     * @psalm-suppress InaccessibleProperty
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
                if ($this->shouldReturnJson($request, $throwable)) {
                    return app(ApiResponse::class)->throw($throwable);
                }
            } catch (\Throwable $throwable) {
                // If catch an exception, only report it,
                // and to let the default exception handler handle original exception.
                report($throwable);
            }
        };
    }
}

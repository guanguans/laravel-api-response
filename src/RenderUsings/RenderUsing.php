<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\RenderUsings;

use Guanguans\LaravelApiResponse\Facades\ApiResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class RenderUsing
{
    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::renderable()
     * @see \Guanguans\LaravelApiResponse\ServiceProvider::registerRenderUsing()
     */
    public function __invoke(\Throwable $throwable, Request $request): ?JsonResponse
    {
        try {
            if ($this->when($request, $throwable)) {
                return ApiResponseFacade::exception($throwable);
            }
        } catch (\Throwable $throwable) {
            // If catch an exception, only report it,
            // and to let the default exception handler handle original exception.
            report($throwable);
        }

        return null;
    }

    abstract protected function when(Request $request, \Throwable $throwable): bool;
}

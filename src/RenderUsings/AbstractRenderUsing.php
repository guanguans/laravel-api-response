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

namespace Guanguans\LaravelApiResponse\RenderUsings;

use Guanguans\LaravelApiResponse\Facades\ApiResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractRenderUsing
{
    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::renderable()
     * @see \Guanguans\LaravelApiResponse\ServiceProvider::registerRenderUsing()
     */
    public function __invoke(\Throwable $throwable, Request $request): ?JsonResponse
    {
        // If catch an exception, only report it,
        // and to let the default exception handler handle original exception.
        return rescue(
            fn (): ?JsonResponse => $this->when($request, $throwable) ? ApiResponseFacade::exception($throwable) : null
        );
    }

    abstract protected function when(Request $request, \Throwable $throwable): bool;
}

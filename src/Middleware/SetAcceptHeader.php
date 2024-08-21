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

namespace Guanguans\LaravelApiResponse\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAcceptHeader
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response $next
     */
    public function handle(Request $request, \Closure $next, string $type = 'json'): Response
    {
        $request->headers->set('Accept', "application/$type");

        return $next($request);
    }
}

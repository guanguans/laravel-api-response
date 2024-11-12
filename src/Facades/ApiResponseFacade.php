<?php

/** @noinspection All */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Facades;

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse success(mixed $data = null, string $message = '', int $code = 200)
 * @method static \Illuminate\Http\JsonResponse error(string $message = '', int $code = 400, array|null $error = null)
 * @method static \Illuminate\Http\JsonResponse exception(\Throwable $throwable)
 * @method static \Illuminate\Http\JsonResponse json(bool $status, int $code, string $message = '', mixed $data = null, null|array $error = null)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToNull()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToInteger()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToFloat()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToString()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToBoolean()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToObject()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castToArray()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse castTo(string $type)
 * @method static \Illuminate\Http\JsonResponse ok(string $message = '', int $code = 200)
 * @method static \Illuminate\Http\JsonResponse created(mixed $data = null, string $message = '', string|null $location = null)
 * @method static \Illuminate\Http\JsonResponse accepted(mixed $data = null, string $message = '', string|null $location = null)
 * @method static \Illuminate\Http\JsonResponse localize(mixed $data = null, string $message = '', int $code = 200, string|null $location = null)
 * @method static \Illuminate\Http\JsonResponse noContent(string $message = '')
 * @method static \Illuminate\Http\JsonResponse badRequest(string $message = '')
 * @method static \Illuminate\Http\JsonResponse unauthorized(string $message = '')
 * @method static \Illuminate\Http\JsonResponse paymentRequired(string $message = '')
 * @method static \Illuminate\Http\JsonResponse forbidden(string $message = '')
 * @method static \Illuminate\Http\JsonResponse notFound(string $message = '')
 * @method static \Illuminate\Http\JsonResponse methodNotAllowed(string $message = '')
 * @method static \Illuminate\Http\JsonResponse requestTimeout(string $message = '')
 * @method static \Illuminate\Http\JsonResponse conflict(string $message = '')
 * @method static \Illuminate\Http\JsonResponse teapot(string $message = '')
 * @method static \Illuminate\Http\JsonResponse unprocessableEntity(string $message = '')
 * @method static \Illuminate\Http\JsonResponse tooManyRequests(string $message = '')
 * @method static \Guanguans\LaravelApiResponse\ApiResponse|mixed when(\Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse|mixed unless(\Closure|mixed|null $value = null, callable|null $callback = null, callable|null $default = null)
 * @method static never dd(void ...$args)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse dump(void ...$args)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse unshiftExceptionPipes(void ...$exceptionPipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse pushExceptionPipes(void ...$exceptionPipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse beforeExceptionPipes(string $findExceptionPipe, void ...$exceptionPipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse afterExceptionPipes(string $findExceptionPipe, void ...$exceptionPipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse removeExceptionPipes(string ...$findExceptionPipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse extendExceptionPipes(callable $callback)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse tapExceptionPipes(callable $callback)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse unshiftPipes(void ...$pipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse pushPipes(void ...$pipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse beforePipes(string $findPipe, void ...$pipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse afterPipes(string $findPipe, void ...$pipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse removePipes(string ...$findPipes)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse extendPipes(callable $callback)
 * @method static \Guanguans\LaravelApiResponse\ApiResponse tapPipes(callable $callback)
 * @method static mixed withLocale(string $locale, \Closure $callback)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static \Guanguans\LaravelApiResponse\ApiResponse|\Illuminate\Support\HigherOrderTapProxy tap(callable|null $callback = null)
 * @method static array convertExceptionToArray(\Throwable $throwable)
 *
 * @see \Guanguans\LaravelApiResponse\ApiResponse
 */
class ApiResponseFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ApiResponseContract::class;
    }
}

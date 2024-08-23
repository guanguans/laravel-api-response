<?php

/** @noinspection LaravelFunctionsInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Symfony\Component\HttpFoundation\Response;

return [
    /**
     * @see \Guanguans\LaravelApiResponse\ApiResponseServiceProvider::registerRenderUsing()
     */
    'render_using_factory' => Guanguans\LaravelApiResponse\RenderUsingFactories\DefaultRenderUsingFactory::class,

    'exception_pipes' => [
        /*
         * Before...
         */

        /*
         * After...
         */
        Guanguans\LaravelApiResponse\ExceptionPipes\HttpExceptionPipe::class,
        Guanguans\LaravelApiResponse\ExceptionPipes\AuthenticationExceptionPipe::class,
        Guanguans\LaravelApiResponse\ExceptionPipes\ValidationExceptionPipe::class,
    ],

    'pipes' => [
        /*
         * Before...
         */
        Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\ToJsonResponseDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\DefaultDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\MessagePipe::with(),
        Guanguans\LaravelApiResponse\Pipes\ErrorPipe::with(/* ! app()->hasDebugModeEnabled() */),

        /*
         * After...
         */
        // Guanguans\LaravelApiResponse\Pipes\SetStatusCodePipe::with(),
    ],
];

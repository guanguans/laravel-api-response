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

use Guanguans\LaravelApiResponse\ExceptionPipes\HttpExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetCodeExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetErrorExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetMessageExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\ValidationExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\WithHeadersExceptionPipe;
use Guanguans\LaravelApiResponse\Pipes\ErrorPipe;
use Guanguans\LaravelApiResponse\Pipes\MessagePipe;
use Guanguans\LaravelApiResponse\Pipes\NullDataPipe;
use Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ScalarDataPipe;
use Guanguans\LaravelApiResponse\Pipes\StatusCodePipe;
use Guanguans\LaravelApiResponse\Pipes\ToJsonResponseDataPipe;
use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Guanguans\LaravelApiResponse\RenderUsings\ShouldReturnJsonRenderUsing;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

return [
    /**
     * Render using.
     */
    'render_using' => ShouldReturnJsonRenderUsing::class,
    // 'render_using' => ApiPathsRenderUsing::make([
    //     'api/*',
    // ]),

    /**
     * Exception pipes.
     */
    'exception_pipes' => [
        /*
         * Before...
         */

        /*
         * After...
         */
        HttpExceptionPipe::class,
        ValidationExceptionPipe::class,
        SetCodeExceptionPipe::with(
            Response::HTTP_UNAUTHORIZED,
            AuthenticationException::class,
            // class...
            // ...
        ),
        SetMessageExceptionPipe::with(
            'Server Error',
            // class...
            // ...
        ),
        WithHeadersExceptionPipe::make(
            [
                // header...
                // ...
            ],
            // class...
            // ...
        ),
        SetErrorExceptionPipe::make(
            null
            // class...
            // ...
        ),
    ],

    /**
     * Pipes.
     */
    'pipes' => [
        /*
         * Before...
         */
        PaginatorDataPipe::class,
        ToJsonResponseDataPipe::class,
        NullDataPipe::with(false),
        ScalarDataPipe::with(false),
        MessagePipe::with(),
        ErrorPipe::with(/* ! app()->hasDebugModeEnabled() */),

        /*
         * After...
         */
        // StatusCodePipe::with(),
    ],
];

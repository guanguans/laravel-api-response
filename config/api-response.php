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

return [
    /**
     * @see Guanguans\LaravelApiResponse\ApiResponseServiceProvider::registerRenderUsing()
     * @see Illuminate\Foundation\Exceptions\Handler::renderable()
     * @see Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing::class
     *
     * Render using.
     */
    // 'render_using' => new Guanguans\LaravelApiResponse\RenderUsingFactories\ApiPathsRenderUsing([
    //     'api/*',
    // ]),
    'render_using' => Guanguans\LaravelApiResponse\RenderUsings\ShouldReturnJsonRenderUsing::class,

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
        Guanguans\LaravelApiResponse\ExceptionPipes\HttpExceptionPipe::class,
        Guanguans\LaravelApiResponse\ExceptionPipes\AuthenticationExceptionPipe::class,
        Guanguans\LaravelApiResponse\ExceptionPipes\ValidationExceptionPipe::class,
        Guanguans\LaravelApiResponse\ExceptionPipes\HideOriginalMessageExceptionPipe::with(
            Illuminate\Database\QueryException::class,
            // Illuminate\Database\Eloquent\ModelNotFoundException::class,
            // Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
        ),
        Guanguans\LaravelApiResponse\ExceptionPipes\SetCodeExceptionPipe::with(
            Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR,
            // class...
            // ...
        ),
        Guanguans\LaravelApiResponse\ExceptionPipes\SetMessageExceptionPipe::with(
            'Server Error',
            // class...
            // ...
        ),
        Guanguans\LaravelApiResponse\ExceptionPipes\WithHeadersExceptionPipe::create(
            [
                // header...
                // ...
            ],
            // class...
            // ...
        ),
        Guanguans\LaravelApiResponse\ExceptionPipes\SetErrorExceptionPipe::create(
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
        Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\ToJsonResponseDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\NullDataPipe::with(false),
        Guanguans\LaravelApiResponse\Pipes\ScalarDataPipe::with(false),
        Guanguans\LaravelApiResponse\Pipes\MessagePipe::with(),
        Guanguans\LaravelApiResponse\Pipes\ErrorPipe::with(/* ! app()->hasDebugModeEnabled() */),

        /*
         * After...
         */
        // Guanguans\LaravelApiResponse\Pipes\StatusCodePipe::with(),
    ],
];

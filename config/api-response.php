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
     * @see Guanguans\LaravelApiResponse\RenderUsingFactories\ApiPathsRenderUsingFactory::class
     *
     * Render using factory.
     */
    // 'render_using_factory' => new Guanguans\LaravelApiResponse\RenderUsingFactories\ApiPathsRenderUsingFactory([
    //     'api/*',
    // ]),
    'render_using_factory' => Guanguans\LaravelApiResponse\RenderUsingFactories\ShouldReturnJsonRenderUsingFactory::class,

    /**
     * Handle exception.
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
    ],

    /**
     * Handle JSON response.
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

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
    'render_using_factory' => Guanguans\LaravelApiResponse\RenderUsingFactory::class,

    /**
     * @see \Guanguans\LaravelApiResponse\ApiResponse::mapException()
     */
    'exception_map' => [
        Illuminate\Auth\AuthenticationException::class => [
            'code' => Response::HTTP_UNAUTHORIZED,
        ],
        // Illuminate\Database\QueryException::class => [
        //     'message' => '',
        //     'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
        // ],
        // Illuminate\Validation\ValidationException::class => [
        //     'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
        // ],
        // Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => [
        //     'message' => '',
        // ],
        // Illuminate\Database\Eloquent\ModelNotFoundException::class => [
        //     'message' => '',
        // ],
    ],

    'pipes' => [
        /*
         * Before...
         */
        Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\DefaultDataPipe::class,
        Guanguans\LaravelApiResponse\Pipes\MessagePipe::with(),
        Guanguans\LaravelApiResponse\Pipes\ErrorPipe::with(/* ! app()->hasDebugModeEnabled() */),

        /*
         * After...
         */
        // Guanguans\LaravelApiResponse\Pipes\SetStatusCodePipe::class::with(),
    ],
];

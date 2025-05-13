<?php

/** @noinspection PhpUnusedAliasInspection */
/** @noinspection LaravelFunctionsInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\ExceptionPipes;
use Guanguans\LaravelApiResponse\Pipes;
use Guanguans\LaravelApiResponse\RenderUsings;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

return [
    /**
     * Render using.
     */
    'render_using' => RenderUsings\ShouldReturnJsonRenderUsing::class,
    // 'render_using' => RenderUsings\ApiPathsRenderUsing::make(
    //     [
    //         'api/*',
    //     ],
    //     [
    //         // except...
    //     ],
    // ),

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
        ExceptionPipes\AuthenticationExceptionPipe::class,
        ExceptionPipes\HttpExceptionPipe::class,
        ExceptionPipes\ValidationExceptionPipe::class,
        ExceptionPipes\SetCodeExceptionPipe::with(
            Response::HTTP_UNAUTHORIZED, // code.
            // class...
        ),
        ExceptionPipes\SetMessageExceptionPipe::with(
            'Whoops! looks like something went wrong.', // message.
            // class...
        ),
        ExceptionPipes\SetErrorExceptionPipe::make(
            [
                // 'message' => 'Whoops, looks like something went wrong.',
                // error...
            ],
            // class...
        ),
        ExceptionPipes\SetHeadersExceptionPipe::make(
            [
                // header...
            ],
            // class...
        ),
    ],

    /**
     * Pipes.
     */
    'pipes' => [
        /*
         * Before...
         */
        Pipes\MessagePipe::with('http-statuses'),
        Pipes\ErrorPipe::with(/* !app()->hasDebugModeEnabled() */),

        // Pipes\NullDataPipe::with(false),
        // Pipes\ScalarDataPipe::with(JsonResource::$wrap),
        Pipes\CallableDataPipe::class,
        Pipes\PaginatorDataPipe::with(/* 'list' */),
        Pipes\JsonResourceDataPipe::class,
        Pipes\JsonResponsableDataPipe::with(),
        Pipes\IterableDataPipe::class,

        /*
         * After...
         */
        Pipes\StatusCodePipe::with(),
    ],
];

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

use Guanguans\LaravelApiResponse\ExceptionPipes\AuthenticationExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\HttpExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetCodeExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetErrorExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetHeadersExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\SetMessageExceptionPipe;
use Guanguans\LaravelApiResponse\ExceptionPipes\ValidationExceptionPipe;
use Guanguans\LaravelApiResponse\Pipes\CallableDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ErrorPipe;
use Guanguans\LaravelApiResponse\Pipes\IterableDataPipe;
use Guanguans\LaravelApiResponse\Pipes\JsonResourceDataPipe;
use Guanguans\LaravelApiResponse\Pipes\JsonResponsableDataPipe;
use Guanguans\LaravelApiResponse\Pipes\MessagePipe;
use Guanguans\LaravelApiResponse\Pipes\NullDataPipe;
use Guanguans\LaravelApiResponse\Pipes\PaginatorDataPipe;
use Guanguans\LaravelApiResponse\Pipes\ScalarDataPipe;
use Guanguans\LaravelApiResponse\Pipes\StatusCodePipe;
use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Guanguans\LaravelApiResponse\RenderUsings\ShouldReturnJsonRenderUsing;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

return [
    /**
     * Render using.
     */
    'render_using' => ShouldReturnJsonRenderUsing::class,
    // 'render_using' => ApiPathsRenderUsing::make(
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
        AuthenticationExceptionPipe::class,
        HttpExceptionPipe::class,
        ValidationExceptionPipe::class,
        SetCodeExceptionPipe::with(
            Response::HTTP_UNAUTHORIZED, // code.
            // class...
        ),
        SetMessageExceptionPipe::with(
            'Whoops! looks like something went wrong.', // message.
            // class...
        ),
        SetErrorExceptionPipe::make(
            [
                // 'message' => 'Whoops, looks like something went wrong.',
                // error...
            ],
            // class...
        ),
        SetHeadersExceptionPipe::make(
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
        MessagePipe::with('http-statuses'),
        ErrorPipe::with(/* !app()->hasDebugModeEnabled() */),

        // NullDataPipe::with(false),
        // ScalarDataPipe::with(JsonResource::$wrap),
        CallableDataPipe::class,
        PaginatorDataPipe::with(/* 'list' */),
        JsonResourceDataPipe::class,
        JsonResponsableDataPipe::with(),
        IterableDataPipe::class,

        /*
         * After...
         */
        StatusCodePipe::with(),
    ],
];

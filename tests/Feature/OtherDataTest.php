<?php

/** @noinspection JsonEncodingApiUsageInspection */
/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {});

/**
 * @see \Guanguans\LaravelApiResponse\Pipes\JsonResponsableDataPipe::dataFor()
 */
it('is psr response', function (array $array): void {
    $psrResponse = new Response(SymfonyResponse::HTTP_OK, ['Content-Type' => 'application/json'], json_encode($array));
    assertMatchesJsonSnapshot($this->apiResponse()->success($psrResponse)->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is symfony response', function (array $array): void {
    $symfonyResponse = new SymfonyResponse(json_encode($array), SymfonyResponse::HTTP_OK, ['Content-Type' => 'application/json']);
    assertMatchesJsonSnapshot($this->apiResponse()->success($symfonyResponse)->content());
})->group(__DIR__, __FILE__)->with('arrays');

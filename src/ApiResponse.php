<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse;

use Guanguans\LaravelApiResponse\Concerns\ConcreteHttpStatusMethods;
use Guanguans\LaravelApiResponse\Concerns\HasExceptionPipes;
use Guanguans\LaravelApiResponse\Concerns\HasPipes;
use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Dumpable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use Symfony\Component\HttpFoundation\Response;

/**
 * @see https://github.com/dingo/api
 * @see https://github.com/f9webltd/laravel-api-response-helpers
 * @see https://github.com/flugg/laravel-responder
 * @see https://github.com/jiannei/laravel-response
 * @see https://github.com/MarcinOrlowski/laravel-api-response-builder
 *
 * @method array convertExceptionToArray(\Throwable $throwable)
 */
class ApiResponse implements ApiResponseContract
{
    // use Dumpable;
    use Conditionable;
    use ConcreteHttpStatusMethods;
    use HasExceptionPipes;
    use HasPipes;
    use Macroable;
    use Tappable;

    public function __construct(?Collection $pipes = null, ?Collection $exceptionPipes = null)
    {
        $this->pipes = collect($pipes);
        $this->exceptionPipes = collect($exceptionPipes);
    }

    /**
     * @param mixed $data
     */
    public function success($data = null, string $message = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->json(true, $code, $message, $data);
    }

    public function error(string $message = '', int $code = Response::HTTP_BAD_REQUEST, ?array $error = null): JsonResponse
    {
        return $this->json(false, $code, $message, null, $error);
    }

    public function exception(\Throwable $throwable): JsonResponse
    {
        [
            'code' => $code,
            'message' => $message,
            'error' => $error,
            'headers' => $headers
        ] = $this
            ->newPipeline()
            ->send($throwable)
            ->through($this->exceptionPipes->all())
            ->then($this->exceptionDestination());

        return $this->error($message, $code, $error)->withHeaders($headers);
    }

    /**
     * @noinspection CompactReplacementInspection
     *
     * @param int<100, 599>|int<100000, 599999> $code
     * @param mixed $data
     * @param null|array<string, mixed> $error
     */
    public function json(bool $status, int $code, string $message = '', $data = null, ?array $error = null): JsonResponse
    {
        return $this
            ->newPipeline()
            ->send([
                'status' => $status,
                'code' => $code,
                'message' => $message,
                'data' => $data,
                'error' => $error,
            ])
            ->through($this->pipes->all())
            ->then($this->destination());
    }

    protected function newPipeline(): Pipeline
    {
        return new Pipeline(app());
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::render()
     * @see \Illuminate\Foundation\Exceptions\Handler::prepareException()
     * @see \Illuminate\Foundation\Exceptions\Handler::prepareJsonResponse()
     * @see \Illuminate\Foundation\Exceptions\Handler::convertExceptionToArray()
     * @see \Illuminate\Database\QueryException
     */
    protected function exceptionDestination(): \Closure
    {
        return static fn (\Throwable $throwable): array => [
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => app()->hasDebugModeEnabled() ? $throwable->getMessage() : '',
            'error' => (fn (): array => $this->convertExceptionToArray($throwable))->call(app(ExceptionHandler::class)),
            'headers' => [],
        ];
    }

    protected function destination(): \Closure
    {
        return static function (array $data): JsonResponse {
            $options = \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_LINE_TERMINATORS
                | \JSON_HEX_TAG | \JSON_HEX_APOS | \JSON_HEX_AMP | \JSON_HEX_QUOT;

            $data['status'] or $options |= \JSON_PRETTY_PRINT;

            return new JsonResponse(
                $data,
                Response::HTTP_OK,
                [],
                $options
            );
        };
    }
}

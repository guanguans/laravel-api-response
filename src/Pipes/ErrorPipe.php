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

namespace Guanguans\LaravelApiResponse\Pipes;

use Guanguans\LaravelApiResponse\Support\Traits\WithPipeArgs;
use Illuminate\Http\JsonResponse;

class ErrorPipe
{
    use WithPipeArgs;

    /**
     * @noinspection RedundantDocCommentTagInspection
     *
     * @param \Closure(array): \Illuminate\Http\JsonResponse $next
     * @param  array{
     *  status: bool,
     *  code: int,
     *  message: string,
     *  data: mixed,
     *  error: ?array,
     * }  $data
     */
    public function handle(array $data, \Closure $next, bool $hidden = false): JsonResponse
    {
        $data['error'] = $this->errorFor($data);

        if ($hidden) {
            unset($data['error']);
        }

        return $next($data);
    }

    /**
     * @return array|\stdClass
     *
     * @see \Illuminate\Foundation\Exceptions\Handler::convertExceptionToArray()
     */
    private function errorFor(array $data)
    {
        $error = (array) $data['error'];

        if ([] === $error) {
            return (object) $error;
        }

        if (
            isset($error['message'])
            && (empty($error['message']) || 'Server Error' === $error['message'])
        ) {
            $error['message'] = $data['message'];
        }

        return $error;
    }
}

<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Support;

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;

if (!\function_exists('Guanguans\LaravelApiResponse\Support\make')) {
    /**
     * @see https://github.com/yiisoft/yii2/blob/master/framework/BaseYii.php
     *
     * @param array<string, mixed>|string $abstract
     * @param array<string, mixed> $parameters
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function make(array|string $abstract, array $parameters = []): mixed
    {
        if (\is_string($abstract)) {
            return resolve($abstract, $parameters);
        }

        foreach (
            $keys ??= [
                '__abstract',
                '__class',
                '__name',
                '_abstract',
                '_class',
                '_name',
                'abstract',
                'class',
                'name',
            ] as $key
        ) {
            if (isset($abstract[$key])) {
                return make($abstract[$key], $parameters + Arr::except($abstract, $key));
            }
        }

        throw new InvalidArgumentException(\sprintf(
            'The argument of abstract must be an array containing a `%s` element.',
            implode('` or `', $keys)
        ));
    }
}

if (!\function_exists('Guanguans\LaravelApiResponse\Support\env_explode')) {
    /**
     * @noinspection LaravelFunctionsInspection
     */
    function env_explode(string $key, mixed $default = null, string $delimiter = ',', int $limit = \PHP_INT_MAX): mixed
    {
        $env = env($key, $default);

        if (\is_string($env)) {
            return $env ? explode($delimiter, $env, $limit) : [];
        }

        return $env;
    }
}

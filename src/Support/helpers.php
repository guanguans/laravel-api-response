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

if (!trait_exists(\Illuminate\Support\Traits\Dumpable::class)) {
    require_once __DIR__.'/Traits/Dumpable.php';
}

if (!\function_exists('Guanguans\LaravelApiResponse\Support\env_explode')) {
    /**
     * @param non-empty-string $delimiter
     *
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

if (!\function_exists('Guanguans\LaravelApiResponse\Support\make')) {
    /**
     * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Foundation/helpers.php
     * @see https://github.com/yiisoft/yii2/blob/master/framework/BaseYii.php
     *
     * @param array<string, mixed>|string $name
     * @param array<string, mixed> $parameters
     */
    function make(array|string $name, array $parameters = []): mixed
    {
        if (\is_string($name)) {
            return resolve($name, $parameters);
        }

        foreach (
            $keys ??= [
                '__abstract', '__class', '__name',
                '_abstract', '_class', '_name',
                'abstract', 'class', 'name',
            ] as $key
        ) {
            if (isset($name[$key])) {
                return make($name[$key], $parameters + Arr::except($name, $key));
            }
        }

        throw new InvalidArgumentException(
            \sprintf('The argument of name must be an array containing a `%s` element.', implode('` or `', $keys))
        );
    }
}

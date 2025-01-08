<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;

if (!\function_exists('make')) {
    /**
     * @codeCoverageIgnore
     *
     * @param array<string, mixed>|string $abstract
     * @param array<string, mixed> $parameters
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    function make($abstract, array $parameters = [])
    {
        if (!\is_string($abstract) && !\is_array($abstract)) {
            throw new InvalidArgumentException(
                \sprintf('Invalid argument type(string/array): %s.', \gettype($abstract))
            );
        }

        if (\is_string($abstract)) {
            return resolve($abstract, $parameters);
        }

        foreach ($classes = ['__class', '_class', 'class'] as $class) {
            if (isset($abstract[$class])) {
                return make(
                    $abstract[$class],
                    $parameters + Arr::except($abstract, $class),
                );
            }
        }

        throw new InvalidArgumentException(\sprintf(
            'The argument of abstract must be an array containing a `%s` element.',
            implode('` or `', $classes)
        ));
    }
}

if (!\function_exists('env_explode')) {
    /**
     * @noinspection LaravelFunctionsInspection
     *
     * @param mixed $default
     *
     * @return mixed
     */
    function env_explode(string $key, $default = null, string $delimiter = ',', int $limit = \PHP_INT_MAX)
    {
        $env = env($key, $default);

        if (\is_string($env)) {
            return $env ? explode($delimiter, $env, $limit) : [];
        }

        return $env;
    }
}

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

use Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;

if (!\function_exists('make')) {
    /**
     * @psalm-param string|array<string, mixed> $abstract
     *
     * @param mixed $abstract
     *
     * @throws \InvalidArgumentException
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

        $classes = ['__class', '_class', 'class'];

        foreach ($classes as $class) {
            if (!isset($abstract[$class])) {
                continue;
            }

            $parameters = Arr::except($abstract, $class) + $parameters;
            $abstract = $abstract[$class];

            return make($abstract, $parameters);
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

if (!\function_exists('json_pretty_encode')) {
    /**
     * @param mixed $value
     *
     * @throws JsonException
     */
    function json_pretty_encode($value, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $value,
            \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

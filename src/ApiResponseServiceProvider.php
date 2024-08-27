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

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Guanguans\LaravelApiResponse\Support\Macros\CollectionMacro;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ApiResponseServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-api-response')
            ->hasConfigFile();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function packageBooted(): void
    {
        Collection::mixin(new CollectionMacro);
        $this->registerRenderUsing();
    }

    public function packageRegistered(): void
    {
        $this->registerApiResponse();
        $this->registerApiResponseContract();
    }

    public function provides(): array
    {
        return [
            $this->toAlias(ApiResponse::class),
            $this->toAlias(ApiResponseContract::class),
            ApiResponse::class,
            ApiResponseContract::class,
        ];
    }

    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerRenderUsing(): void
    {
        if (
            ($renderUsing = config('api-response.render_using'))
            // && !$this->app->runningInConsole()
            && method_exists($exceptionHandler = $this->app->make(ExceptionHandler::class), 'renderable')
        ) {
            if (!\is_callable($renderUsing)) {
                $renderUsing = make($renderUsing);
            }

            $exceptionHandler->renderable($renderUsing);
        }
    }

    private function registerApiResponse(): void
    {
        $this->app->singleton(
            ApiResponse::class,
            static fn (): ApiResponse => new ApiResponse(
                collect(config('api-response.pipes')),
                collect(config('api-response.exception_pipes'))
            )
        );

        $this->alias(ApiResponse::class);
    }

    private function registerApiResponseContract(): void
    {
        $this->app->bind(
            ApiResponseContract::class,
            static fn (Application $app): ApiResponseContract => $app->make(ApiResponse::class)
        );

        $this->alias(ApiResponseContract::class);
    }

    /**
     * @param class-string $class
     */
    private function alias(string $class): self
    {
        $this->app->alias($class, $this->toAlias($class));

        return $this;
    }

    /**
     * @param class-string $class
     */
    private function toAlias(string $class): string
    {
        return Str::of($class)
            ->replaceFirst(__NAMESPACE__, '')
            ->start('\\'.class_basename(ApiResponse::class))
            ->replaceFirst('\\', '')
            ->explode('\\')
            ->map(static fn (string $name): string => Str::snake($name, '-'))
            ->implode('.');
    }
}

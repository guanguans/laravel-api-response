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

namespace Guanguans\LaravelApiResponse;

use Guanguans\LaravelApiResponse\Contracts\ApiResponseContract;
use Guanguans\LaravelApiResponse\Support\Mixins\CollectionMixin;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use function Guanguans\LaravelApiResponse\Support\make;

class ServiceProvider extends PackageServiceProvider
{
    /**
     * @return list<string>
     */
    public function provides(): array
    {
        return [
            $this->toAlias(ApiResponse::class),
            $this->toAlias(ApiResponseContract::class),
            ApiResponse::class,
            ApiResponseContract::class,
        ];
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-api-response')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->registerApiResponse();
        $this->registerApiResponseContract();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    public function packageBooted(): void
    {
        Collection::mixin(new CollectionMixin);
        $this->registerRenderUsing();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerRenderUsing(): void
    {
        if (
            ($renderUsing = config('api-response.render_using'))
            && method_exists($exceptionHandler = $this->app->make(ExceptionHandler::class), 'renderable')
        ) {
            if (!\is_callable($renderUsing)) {
                $renderUsing = make($renderUsing);
            }

            /** @var \Illuminate\Foundation\Exceptions\Handler $exceptionHandler */
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
            static fn (Application $application): ApiResponseContract => $application->make(ApiResponse::class)
        );

        $this->alias(ApiResponseContract::class);
    }

    /**
     * @param class-string $class
     */
    private function alias(string $class): void
    {
        $this->app->alias($class, $this->toAlias($class));
    }

    /**
     * @param class-string $class
     */
    private function toAlias(string $class): string
    {
        return str($class)
            ->replaceFirst(__NAMESPACE__, '')
            ->start('\\'.class_basename(ApiResponse::class))
            ->replaceFirst('\\', '')
            ->explode('\\')
            ->map(static fn (string $name): string => Str::snake($name, '-'))
            ->implode('.');
    }
}

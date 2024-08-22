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
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     */
    public function packageBooted(): void
    {
        $this->registerRenderUsing();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(
            ApiResponseContract::class,
            static fn (): ApiResponse => new ApiResponse(
                collect(config('api-response.pipes')),
                collect(config('api-response.exception_map'))
            )
        );
        $this->alias(ApiResponseContract::class);
    }

    public function provides(): array
    {
        return [
            $this->toAlias(ApiResponseContract::class),
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
            ($renderUsingFactory = config('api-response.render_using_factory'))
            && !$this->app->runningInConsole()
            && method_exists($exceptionHandler = $this->app->make(ExceptionHandler::class), 'renderable')
        ) {
            if (\is_string($renderUsingFactory) && class_exists($renderUsingFactory)) {
                $renderUsingFactory = $this->app->make($renderUsingFactory);
            }

            /** @var callable(\Throwable, Request): ?JsonResponse $renderUsing */
            $renderUsing = $renderUsingFactory($exceptionHandler);

            if ($renderUsing instanceof \Closure) {
                $renderUsing = $renderUsing->bindTo($exceptionHandler, $exceptionHandler);
            }

            $exceptionHandler->renderable($renderUsing);
        }
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

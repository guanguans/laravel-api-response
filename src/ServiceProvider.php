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
use Illuminate\Support\Collection;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use function Guanguans\LaravelApiResponse\Support\make;

class ServiceProvider extends PackageServiceProvider
{
    /**
     * @api
     *
     * @var array<string, string>
     *
     * @noinspection ClassOverridesFieldOfSuperClassInspection
     */
    public array $bindings = [
        ApiResponseContract::class => ApiResponse::class,
    ];

    /**
     * @return list<string>
     */
    public function provides(): array
    {
        return [
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
                collect((array) config('api-response.pipes')),
                collect((array) config('api-response.exception_pipes'))
            )
        );
    }
}

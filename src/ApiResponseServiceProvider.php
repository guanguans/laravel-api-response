<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse;

use Guanguans\LaravelApiResponse\Commands\TestCommand;
use Guanguans\LaravelApiResponse\Facades\ApiResponse;
use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ApiResponseServiceProvider extends ServiceProvider
{
    public array $singletons = [];

    public function register(): void
    {
        $this->setupConfig()
            // ->registerMacros()
            ->registerApiResponseManager()
            ->registerCollectorManager()
            ->registerTestCommand();
    }

    public function boot(): void
    {
        $this->extendExceptionHandler()
            ->registerCommands();
    }

    public function provides(): array
    {
        return [
            $this->toAlias(CollectorManager::class),
            $this->toAlias(ApiResponseManager::class),
            $this->toAlias(TestCommand::class),
            CollectorManager::class,
            ApiResponseManager::class,
            TestCommand::class,
        ];
    }

    private function setupConfig(): self
    {
        /** @noinspection RealpathInStreamContextInspection */
        $source = realpath($raw = __DIR__.'/../config/exception-notify.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'laravel-api-response');
        }

        $this->mergeConfigFrom($source, 'exception-notify');

        return $this;
    }

    private function registerApiResponseManager(): self
    {
        $this->app->singleton(
            ApiResponseManager::class,
            static fn (Container $container): ApiResponseManager => new ApiResponseManager($container)
        );

        $this->alias(ApiResponseManager::class);

        return $this;
    }

    private function registerCollectorManager(): self
    {
        $this->app->singleton(
            CollectorManager::class,
            static fn (Container $container): CollectorManager => new CollectorManager(
                collect(config('exception-notify.collectors', []))
                    ->map(static function ($parameters, $class) use ($container) {
                        if (!\is_array($parameters)) {
                            [$parameters, $class] = [(array) $class, $parameters];
                        }

                        return $container->make($class, $parameters);
                    })
                    ->all()
            )
        );

        $this->alias(CollectorManager::class);

        return $this;
    }

    private function registerTestCommand(): self
    {
        $this->app->singleton(TestCommand::class);
        $this->alias(TestCommand::class);

        return $this;
    }

    private function extendExceptionHandler(): self
    {
        $this->app->extend(ExceptionHandler::class, static function (ExceptionHandler $exceptionHandler): ExceptionHandler {
            if (method_exists($exceptionHandler, 'reportable')) {
                $exceptionHandler->reportable(static function (\Throwable $throwable) use ($exceptionHandler): void {
                    ApiResponse::reportIf($exceptionHandler->shouldReport($throwable), $throwable);
                });
            }

            return $exceptionHandler;
        });

        return $this;
    }

    private function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestCommand::class,
            ]);
        }

        return $this;
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

<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpMissingDocCommentInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponseTests;

use Guanguans\LaravelApiResponse\Facades\ApiResponseFacade;
use Guanguans\LaravelApiResponse\Middleware\SetJsonAcceptHeader;
use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Guanguans\LaravelApiResponseTests\Laravel\seeders\TablesSeeder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\JsonResource;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    // use DatabaseMigrations;
    // use DatabaseTransactions;
    // use DatabaseTruncation;
    // use InteractsWithViews;
    // use LazilyRefreshDatabase;
    // use WithCachedConfig;
    // use WithCachedRoutes;

    // use VarDumperTestTrait;
    // use PHPMock;

    use ApiResponseFactory;

    // use RefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();
        // \DG\BypassFinals::enable();
        $this->app->useLangPath(__DIR__.'/Laravel/lang');
        JsonResource::wrap(collect([null, 'data'])->random());
    }

    protected function getApplicationTimezone(mixed $app): string
    {
        return 'Asia/Shanghai';
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ApiResponseFacade' => ApiResponseFacade::class,
        ];
    }

    protected function defineEnvironment(mixed $app): void
    {
        tap($app->make(Repository::class), function (Repository $repository): void {
            $repository->set('app.key', 'base64:UZ5sDPZSB7DSLKY+DYlU8G/V1e/qW+Ag0WF03VNxiSg=');
            $repository->set('app.debug', false);

            $repository->set('database.default', 'sqlite');
            $repository->set('database.connections.sqlite.database', ':memory:');

            $repository->set('mail.default', 'log');
        });
    }

    /**
     * @see https://github.com/staudenmeir/eloquent-eager-limit
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Laravel/migrations');
    }

    protected function defineDatabaseSeeders(): void
    {
        $this->seed(TablesSeeder::class);
    }

    protected function defineRoutes($router): void
    {
        $router->any('api/exception', static function (): void {
            config('api-response.render_using', ApiPathsRenderUsing::make());

            throw new \RuntimeException('This is a runtime exception.', Response::HTTP_BAD_GATEWAY);
        })->middleware(SetJsonAcceptHeader::class);
    }
}

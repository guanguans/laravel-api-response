<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpMissingDocCommentInspection */
/** @noinspection PhpUnusedAliasInspection */
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
use Guanguans\LaravelApiResponse\Support\Traits\ApiResponseFactory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Lottery;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Workbench\Database\Seeders\DatabaseSeeder;

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

        tap($app, function (Application $application): void {
            $application->useLangPath(__DIR__.'/../workbench/resources/lang/');
            JsonResource::wrap(
                Lottery::odds(4, 5)->winner(static fn (): string => 'data')->loser(static fn () => null)->choose()
            );

            $application->has('pushed-pipe') or $this
                ->apiResponse()
                ->pushPipes(function (array $structure, \Closure $next) use ($application): JsonResponse {
                    $application->instance('pushed-pipe', true);
                    $jsonResponse = $next($structure);
                    \assert($jsonResponse instanceof JsonResponse);

                    /** @see https://github.com/guanguans/php-cs-fixer-custom-fixers/blob/main/src/Fixer/InlineHtml/JsonFixer.php */
                    return $jsonResponse->setEncodingOptions(
                        \JSON_INVALID_UTF8_IGNORE |
                        \JSON_INVALID_UTF8_SUBSTITUTE |
                        \JSON_PARTIAL_OUTPUT_ON_ERROR |
                        \JSON_PRESERVE_ZERO_FRACTION |
                        \JSON_PRETTY_PRINT |
                        \JSON_THROW_ON_ERROR |
                        \JSON_UNESCAPED_SLASHES |
                        \JSON_UNESCAPED_UNICODE
                    );
                });
        });
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../workbench/database/migrations/');
    }

    protected function defineDatabaseSeeders(): void
    {
        $this->seed(DatabaseSeeder::class);
    }
}

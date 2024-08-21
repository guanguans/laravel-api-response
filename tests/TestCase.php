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

namespace Guanguans\LaravelApiResponse\Tests;

use Guanguans\LaravelApiResponse\ApiResponseServiceProvider;
use Guanguans\LaravelApiResponse\Collectors\ApplicationCollector;
use Guanguans\LaravelApiResponse\Collectors\ChoreCollector;
use Guanguans\LaravelApiResponse\Collectors\ExceptionBasicCollector;
use Guanguans\LaravelApiResponse\Collectors\ExceptionContextCollector;
use Guanguans\LaravelApiResponse\Collectors\ExceptionTraceCollector;
use Guanguans\LaravelApiResponse\Collectors\PhpInfoCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestBasicCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestCookieCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestFileCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestHeaderCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestMiddlewareCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestPostCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestQueryCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestRawFileCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestServerCollector;
use Guanguans\LaravelApiResponse\Collectors\RequestSessionCollector;
use Guanguans\LaravelApiResponse\Exceptions\RuntimeException;
use Guanguans\LaravelApiResponse\Facades\ApiResponse;
use Guanguans\LaravelApiResponse\Pipes\AddKeywordChorePipe;
use Guanguans\LaravelApiResponse\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelApiResponse\Pipes\LimitLengthPipe;
use Guanguans\LaravelApiResponse\Pipes\ReplaceStrPipe;
use Guanguans\LaravelApiResponse\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelApiResponse\Pipes\SprintfMarkdownPipe;
use Guanguans\Notify\Foundation\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MockeryPHPUnitIntegration;
    use VarDumperTestTrait;
    use Faker;

    protected function setUp(): void
    {
        self::markTestSkipped('@todo');
        parent::setUp();
        $this->startMockery();
    }

    protected function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ApiResponseServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        config()->set('exception-notify.job.queue', 'exception-notify');
        config()->set('exception-notify.channels.bark.authenticator.token', $this->faker()->uuid());
        config()->set('exception-notify.channels.bark.client.http_options', []);
        config()->set('exception-notify.channels.bark.client.extender', static fn (Client $client): Client => $client->mock([
            (new HttpFactory)->createResponse(200, '{"code":200,"message":"success","timestamp":1708331409}'),
        ]));
        config()->set('exception-notify.collectors', [
            ApplicationCollector::class,
            ChoreCollector::class,
            ExceptionBasicCollector::class,
            ExceptionContextCollector::class,
            ExceptionTraceCollector::class,
            PhpInfoCollector::class,
            RequestBasicCollector::class,
            RequestCookieCollector::class,
            RequestFileCollector::class,
            RequestHeaderCollector::class,
            RequestMiddlewareCollector::class,
            RequestPostCollector::class,
            RequestQueryCollector::class,
            RequestRawFileCollector::class,
            RequestServerCollector::class,
            RequestSessionCollector::class,
        ]);
        config()->set('exception-notify.channels.log.pipes', [
            hydrate_pipe(AddKeywordChorePipe::class, 'keyword'),
            SprintfHtmlPipe::class,
            SprintfMarkdownPipe::class,
            FixPrettyJsonPipe::class,
            hydrate_pipe(LimitLengthPipe::class, 512),
            hydrate_pipe(ReplaceStrPipe::class, '.php', '.PHP'),
        ]);
    }

    protected function defineRoutes($router): void
    {
        $router->any('report-exception', static fn () => tap(response('report-exception'), static function (): void {
            ApiResponse::report(new RuntimeException('What happened?'), ['dump', 'log', 'bark', 'lark']);
        }));

        $router->any('exception', static fn () => tap(response('exception'), static function (): void {
            throw new RuntimeException('What happened?');
        }));
    }
}

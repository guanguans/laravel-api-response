<?php

/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Composer\Autoload\ClassLoader;
use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\LaravelApiResponse\Support\Rectors\ToInternalExceptionRector;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DowngradePhp81\Rector\Array_\DowngradeArraySpreadStringKeyRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Transform\Rector\Scalar\ScalarValueToConstFetchRector;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Rector\Transform\ValueObject\ScalarValueToConstFetch;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Set\LaravelSetList;
use Symfony\Component\HttpFoundation\Response;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
        ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
        __DIR__.'/composer-updater',
    ])
    ->withRootFiles()
    // ->withSkipPath(__DIR__.'/tests.php')
    ->withSkip([
        '**/__snapshots__/*',
        '**/Fixtures/*',
        __DIR__.'/src/RenderUsings/RenderUsing.php',
        // __FILE__,
    ])
    ->withCache(__DIR__.'/.build/rector/')
    ->withParallel()
    // ->withoutParallel()
    // ->withImportNames(importNames: false)
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withPhpVersion(PhpVersion::PHP_80)
    ->withFluentCallNewLine()
    ->withAttributesSets(phpunit: true)
    ->withComposerBased(phpunit: true)
    ->withPhpVersion(PhpVersion::PHP_80)
    ->withDowngradeSets(php80: true)
    ->withPhpSets(php80: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        phpunitCodeQuality: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_90,
        LaravelSetList::LARAVEL_90,
        ...collect((new ReflectionClass(LaravelSetList::class))->getConstants(ReflectionClassConstant::IS_PUBLIC))
            ->reject(
                static fn (
                    string $constant,
                    string $name
                ): bool => \in_array($name, ['LARAVEL_STATIC_TO_INJECTION', 'LARAVEL_'], true)
                    || preg_match('/^LARAVEL_\d{2,3}$/', $name)
            )
            // ->dd()
            ->values()
            ->all(),
    ])
    ->withRules([
        ArraySpreadInsteadOfArrayMergeRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        ToInternalExceptionRector::class,
        ...collect(spl_autoload_functions())
            ->pipe(static fn (Collection $splAutoloadFunctions): Collection => collect(
                $splAutoloadFunctions
                    ->firstOrFail(
                        static fn (mixed $loader): bool => \is_array($loader) && $loader[0] instanceof ClassLoader
                    )[0]
                    ->getClassMap()
            ))
            ->keys()
            ->filter(static fn (string $class): bool => str_starts_with($class, 'RectorLaravel\Rector'))
            ->filter(static fn (string $class): bool => (new ReflectionClass($class))->isInstantiable())
            // ->filter(static fn (string $class): bool => is_subclass_of($class, ConfigurableRectorInterface::class))
            ->values()
            // ->dd()
            ->all(),
    ])
    ->withConfiguredRule(RemoveAnnotationRector::class, [
        'codeCoverageIgnore',
        'phpstan-ignore',
        'phpstan-ignore-next-line',
        'psalm-suppress',
    ])
    ->withConfiguredRule(StaticCallToFuncCallRector::class, [
        new StaticCallToFuncCall(Str::class, 'of', 'str'),
    ])
    // ->withConfiguredRule(FuncCallToStaticCallRector::class, [
    //     new FuncCallToStaticCall('str', Str::class, 'of'),
    // ])
    ->withConfiguredRule(ScalarValueToConstFetchRector::class, array_map(
        static fn (int $value, string $constant): ScalarValueToConstFetch => new ScalarValueToConstFetch(
            new LNumber($value),
            new ClassConstFetch(new FullyQualified(Response::class), new Identifier($constant))
        ),
        $constants = array_filter(
            (new ReflectionClass(Response::class))->getConstants(),
            static fn ($value): bool => \is_int($value),
        ),
        array_keys($constants)
    ))
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'Pest\Faker\fake' => 'fake',
            'Pest\Faker\faker' => 'faker',
            // 'faker' => 'fake',
            'test' => 'it',
        ] + array_reduce(
            [
                'make',
                'env_explode',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\LaravelApiResponse\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    ->withSkip([
        ChangeOrIfContinueToMultiContinueRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        DispatchToHelperFunctionsRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        HelperFuncCallToFacadeClassRector::class,
        ModelCastsPropertyToCastsMethodRector::class,
        TypeHintTappableCallRector::class,
    ])
    ->withSkip([
        DowngradeArraySpreadStringKeyRector::class => [
            __DIR__.'/.php-cs-fixer.php',
            __DIR__.'/src/Concerns/HasExceptionPipes.php',
            __DIR__.'/src/Concerns/HasPipes.php',
            __FILE__,
        ],
        DisallowedEmptyRuleFixerRector::class => [
            __DIR__.'/src/Pipes/PaginatorDataPipe.php',
            __DIR__.'/src/Pipes/ScalarDataPipe.php',
        ],
        RemoveDumpDataDeadCodeRector::class => [
            __DIR__.'/src/Support/Traits/Dumpable.php',
            __DIR__.'/tests/Feature/ExceptionTest.php',
        ],
        RemoveUselessReturnTagRector::class => [
            __DIR__.'/src/Support/Traits/ApiResponseFactory.php',
        ],
        ToInternalExceptionRector::class => [
            __DIR__.'/tests',
        ],
        ScalarValueToConstFetchRector::class => [
            __DIR__.'/composer-updater',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
        SortAssociativeArrayByKeyRector::class => [
            __DIR__.'/config',
            __DIR__.'/src',
            __DIR__.'/tests',
        ],
    ]);

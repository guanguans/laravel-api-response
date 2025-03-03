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

use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\LaravelApiResponse\Support\Rectors\ToInternalExceptionRector;
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
use RectorLaravel\Set\LaravelSetList;
use Symfony\Component\HttpFoundation\Response;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/composer-updater',
    ])
    ->withRootFiles()
    // ->withSkipPath(__DIR__.'/tests.php')
    ->withSkip([
        '**/__snapshots__/*',
        '**/Fixtures/*',
        __DIR__.'/src/RenderUsings/RenderUsing.php',
        __FILE__,
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
        // LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
    ])
    ->withRules([
        ArraySpreadInsteadOfArrayMergeRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        ToInternalExceptionRector::class,
    ])
    ->withRules([
        // // RectorLaravel\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector::class,
        // // RectorLaravel\Rector\Cast\DatabaseExpressionCastsToMethodCallRector::class,
        RectorLaravel\Rector\ClassMethod\AddParentBootToModelClassMethodRector::class,
        RectorLaravel\Rector\ClassMethod\AddParentRegisterToEventServiceProviderRector::class,
        RectorLaravel\Rector\ClassMethod\MigrateToSimplifiedAttributeRector::class,
        RectorLaravel\Rector\Class_\AddExtendsAnnotationToModelFactoriesRector::class,
        RectorLaravel\Rector\Class_\AddMockConsoleOutputFalseToConsoleTestsRector::class,
        RectorLaravel\Rector\Class_\AnonymousMigrationsRector::class,
        // RectorLaravel\Rector\Class_\ModelCastsPropertyToCastsMethodRector::class,
        RectorLaravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class,
        RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector::class,
        // // RectorLaravel\Rector\Class_\ReplaceExpectsMethodsInTestsRector::class,
        // // RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector::class,
        // RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector::class,
        RectorLaravel\Rector\Expr\AppEnvironmentComparisonToParameterRector::class,
        RectorLaravel\Rector\Expr\SubStrToStartsWithOrEndsWithStaticMethodCallRector\SubStrToStartsWithOrEndsWithStaticMethodCallRector::class,
        // // RectorLaravel\Rector\FuncCall\DispatchNonShouldQueueToDispatchSyncRector::class,
        // // RectorLaravel\Rector\FuncCall\FactoryFuncCallToStaticCallRector::class,
        // RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector::class,
        RectorLaravel\Rector\FuncCall\NotFilledBlankFuncCallToBlankFilledFuncCallRector::class,
        RectorLaravel\Rector\FuncCall\NowFuncWithStartOfDayMethodCallToTodayFuncRector::class,
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class,
        RectorLaravel\Rector\FuncCall\RemoveRedundantValueCallsRector::class,
        RectorLaravel\Rector\FuncCall\RemoveRedundantWithCallsRector::class,
        RectorLaravel\Rector\FuncCall\SleepFuncToSleepStaticCallRector::class,
        RectorLaravel\Rector\FuncCall\ThrowIfAndThrowUnlessExceptionsToUseClassStringRector::class,
        RectorLaravel\Rector\If_\AbortIfRector::class,
        RectorLaravel\Rector\If_\ReportIfRector::class,
        // RectorLaravel\Rector\If_\ThrowIfRector::class,
        RectorLaravel\Rector\MethodCall\AssertStatusToAssertMethodRector::class,
        RectorLaravel\Rector\MethodCall\ChangeQueryWhereDateValueWithCarbonRector::class,
        // // RectorLaravel\Rector\MethodCall\DatabaseExpressionToStringToMethodCallRector::class,
        RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector::class,
        RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector::class,
        // // RectorLaravel\Rector\MethodCall\FactoryApplyingStatesRector::class,
        RectorLaravel\Rector\MethodCall\JsonCallToExplicitJsonCallRector::class,
        // RectorLaravel\Rector\MethodCall\LumenRoutesStringActionToUsesArrayRector::class,
        // RectorLaravel\Rector\MethodCall\LumenRoutesStringMiddlewareToArrayRector::class,
        RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector::class,
        RectorLaravel\Rector\MethodCall\RedirectRouteToToRouteHelperRector::class,
        RectorLaravel\Rector\MethodCall\RefactorBlueprintGeometryColumnsRector::class,
        // // RectorLaravel\Rector\MethodCall\ReplaceWithoutJobsEventsAndNotificationsWithFacadeFakeRector::class,
        RectorLaravel\Rector\MethodCall\UseComponentPropertyWithinCommandsRector::class,
        RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector::class,
        // // RectorLaravel\Rector\Namespace_\FactoryDefinitionRector::class,
        RectorLaravel\Rector\New_\AddGuardToLoginEventRector::class,
        RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector::class,
        RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector::class,
        // RectorLaravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class,
        RectorLaravel\Rector\StaticCall\Redirect301ToPermanentRedirectRector::class,
        // // RectorLaravel\Rector\StaticCall\ReplaceAssertTimesSendWithAssertSentTimesRector::class,
    ])
    ->withRules([
        // // RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector::class,
        // // RectorLaravel\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class,
        // RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class,
        // RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector::class,
        // RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector::class,
        // // RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector::class,
        // RectorLaravel\Rector\StaticCall\RouteActionCallableRector::class,
    ])
    ->withConfiguredRule(RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class, [
    ])
    ->withConfiguredRule(RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector::class, [
    ])
    ->withConfiguredRule(RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector::class, [
    ])
    ->withConfiguredRule(RectorLaravel\Rector\StaticCall\RouteActionCallableRector::class, [
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
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        DowngradeArraySpreadStringKeyRector::class => [
            __DIR__.'/.php-cs-fixer.php',
            __DIR__.'/src/Concerns/HasPipes.php',
            __DIR__.'/src/Concerns/HasExceptionPipes.php',
        ],
        DisallowedEmptyRuleFixerRector::class => [
            __DIR__.'/src/Pipes/PaginatorDataPipe.php',
            __DIR__.'/src/Pipes/ScalarDataPipe.php',
        ],
        RemoveUselessReturnTagRector::class => [
            __DIR__.'/src/Support/Traits/ApiResponseFactory.php',
        ],
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class => [
            __DIR__.'/src/Support/Traits/Dumpable.php',
            __DIR__.'/tests/Feature/ExceptionTest.php',
        ],
        ToInternalExceptionRector::class => [
            __DIR__.'/tests',
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

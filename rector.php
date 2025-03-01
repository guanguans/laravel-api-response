<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\Support\Rectors\ToInternalExceptionRector;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Scalar\LNumber;
use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DowngradePhp81\Rector\Array_\DowngradeArraySpreadStringKeyRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php74\Rector\Ternary\ParenthesizeNestedTernaryRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Set\ValueObject\DowngradeLevelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Transform\Rector\FuncCall\FuncCallToStaticCallRector;
use Rector\Transform\Rector\Scalar\ScalarValueToConstFetchRector;
use Rector\Transform\ValueObject\FuncCallToStaticCall;
use Rector\Transform\ValueObject\ScalarValueToConstFetch;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Set\LaravelSetList;
use Symfony\Component\HttpFoundation\Response;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/*.php',
        __DIR__.'/.*.php',
        __DIR__.'/composer-updater',
    ])
    ->withParallel()
    // ->withoutParallel()
    ->withImportNames(false)
    ->withAttributesSets()
    ->withDeadCodeLevel(42)
    ->withTypeCoverageLevel(37)
    ->withFluentCallNewLine()
    // ->withPhpSets()
    // ->withPreparedSets()
    ->withSets([
        DowngradeLevelSetList::DOWN_TO_PHP_74,
        LevelSetList::UP_TO_PHP_74,
    ])
    ->withSets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        // SetList::DEAD_CODE,
        // SetList::STRICT_BOOLEANS,
        // SetList::GMAGICK_TO_IMAGICK,
        SetList::NAMING,
        // SetList::PRIVATIZATION,
        // SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
    ])
    ->withSets([
        PHPUnitSetList::PHPUNIT_90,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ])
    ->withSets([
        LaravelSetList::LARAVEL_80,
        // LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
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
    ->withRules([
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
        ToInternalExceptionRector::class,
    ])
    ->withConfiguredRule(RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class, [
    ])
    ->withConfiguredRule(RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector::class, [
    ])
    ->withConfiguredRule(RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector::class, [
    ])
    ->withConfiguredRule(RectorLaravel\Rector\StaticCall\RouteActionCallableRector::class, [
    ])
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'test' => 'it',
        ] + array_reduce(
            [
                // 'make',
                // 'env_explode',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\LaravelApiResponse\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    // ->withConfiguredRule(StaticCallToFuncCallRector::class, [
    //     new StaticCallToFuncCall(Str::class, 'of', 'str'),
    // ])
    ->withConfiguredRule(FuncCallToStaticCallRector::class, [
        new FuncCallToStaticCall('str', Str::class, 'of'),
    ])
    ->withConfiguredRule(ScalarValueToConstFetchRector::class, array_map(
        static fn (int $value, string $constant): ScalarValueToConstFetch => new ScalarValueToConstFetch(
            new LNumber($value),
            new ClassConstFetch(new FullyQualified(Response::class), new Identifier($constant))
        ),
        $constants = array_filter(
            (new \ReflectionClass(Response::class))->getConstants(),
            static fn ($value): bool => \is_int($value),
        ),
        array_keys($constants)
    ))
    ->withSkip([
        '**/fixtures/*',
        '**/Fixtures/*',
        '**/__snapshots__/*',
        __DIR__.'/src/RenderUsings/RenderUsing.php',
    ])
    ->withSkip([
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        ExplicitReturnNullRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        RenameParamToMatchTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        DowngradeArraySpreadStringKeyRector::class => [
            __DIR__.'/src/Concerns/HasPipes.php',
            __DIR__.'/src/Concerns/HasExceptionPipes.php',
        ],
        DisallowedEmptyRuleFixerRector::class => [
            __DIR__.'/src/Pipes/PaginatorDataPipe.php',
            __DIR__.'/src/Pipes/ScalarDataPipe.php',
        ],
        ParenthesizeNestedTernaryRector::class => [
            __DIR__.'/src/Pipes/MessagePipe.php',
        ],
        RemoveExtraParametersRector::class => [
            // __DIR__.'/src/Mixins/QueryBuilderMacro.php',
        ],
        RemoveUselessReturnTagRector::class => [
            __DIR__.'/src/Support/Traits/ApiResponseFactory.php',
        ],
        RenameFunctionRector::class => [
            // __DIR__.'/src/Support/helpers.php',
        ],
        RenameForeachValueVariableToMatchExprVariableRector::class => [
            // __DIR__.'/src/OutputManager.php',
        ],
        RemoveDumpDataDeadCodeRector::class => [
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
    ]);

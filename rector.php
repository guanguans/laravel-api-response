<?php

/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Ergebnis\Rector\Rules\Arrays\SortAssociativeArrayByKeyRector;
use Guanguans\LaravelApiResponse\Support\Rector\ConcreteHttpStatusRector;
use Guanguans\RectorRules\Rector\File\AddNoinspectionDocblockToFileFirstStmtRector;
use Guanguans\RectorRules\Rector\Name\RenameToConventionalCaseNameRector;
use Guanguans\RectorRules\Set\SetList;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\ArrowFunctionDelegatingCallToFirstClassCallableRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassLike\RemoveAnnotationRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php81\Rector\Array_\ArrayToFirstClassCallableRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\Transform\Rector\Scalar\ScalarValueToConstFetchRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\ConfigToTypedConfigMethodCallRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\FuncCall\TypeHintTappableCallRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Set\LaravelSetProvider;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/config/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        __DIR__.'/workbench/',
        __DIR__.'/composer-bump',
    ])
    ->withRootFiles()
    ->withSkip([
        '*/Fixtures/*',
        __DIR__.'/src/Concerns/HasExceptionPipes.php',
        __DIR__.'/src/Concerns/HasPipes.php',
        __DIR__.'/tests.php',
    ])
    ->withCache(__DIR__.'/.build/rector/')
    // ->withoutParallel()
    ->withParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    // ->withImportNames(importNames: false)
    // ->withEditorUrl()
    ->withFluentCallNewLine()
    ->withTreatClassesAsFinal()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true, laravel: true)
    ->withSetProviders(LaravelSetProvider::class)
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withDowngradeSets(php81: true)
    ->withPhpSets(php81: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        carbon: true,
    )
    ->withSets([
        SetList::ALL,
    ])
    ->withRules([
        ArraySpreadInsteadOfArrayMergeRector::class,
        ConcreteHttpStatusRector::class,
        JsonThrowOnErrorRector::class,
        SafeDeclareStrictTypesRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
    ])
    ->withConfiguredRule(AddNoinspectionDocblockToFileFirstStmtRector::class, [
        '*/tests/*' => [
            'AnonymousFunctionStaticInspection',
            'NullPointerExceptionInspection',
            'PhpPossiblePolymorphicInvocationInspection',
            'PhpUndefinedClassInspection',
            'PhpUnhandledExceptionInspection',
            'PhpVoidFunctionResultUsedInspection',
            // 'SqlResolve',
            'StaticClosureCanBeUsedInspection',
        ],
    ])
    ->registerDecoratingNodeVisitor(ParentConnectingVisitor::class)
    ->withConfiguredRule(RenameToConventionalCaseNameRector::class, [
        'beforeEach',
        'MIT',
        'PDO',
    ])
    ->withConfiguredRule(RemoveAnnotationRector::class, [
        'codeCoverageIgnore',
        'inheritDoc',
        'phpstan-ignore',
        'phpstan-ignore-next-line',
        'psalm-suppress',
    ])
    ->withSkip([
        // ArrayToFirstClassCallableRector::class,
        // ArrowFunctionDelegatingCallToFirstClassCallableRector::class,
        ScalarValueToConstFetchRector::class,

        ChangeOrIfContinueToMultiContinueRector::class,
        DisallowedEmptyRuleFixerRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        NewlineBetweenClassLikeStmtsRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        ConfigToTypedConfigMethodCallRector::class,
        TypeHintTappableCallRector::class,

        ArrayToArrGetRector::class,
        DispatchToHelperFunctionsRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        HelperFuncCallToFacadeClassRector::class,
        ThrowIfRector::class,
    ])
    ->withSkip([
        RemoveDumpDataDeadCodeRector::class => [
            __DIR__.'/src/Support/Traits/Dumpable.php',
            __DIR__.'/tests/Feature/ExceptionTest.php',
        ],
        SortAssociativeArrayByKeyRector::class => [
            // __DIR__.'/config/',
            __DIR__.'/src/',
            __DIR__.'/tests/',
            __DIR__.'/workbench/',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests/',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
    ]);

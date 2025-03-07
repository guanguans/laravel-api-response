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

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration)
    ->addPathsToScan(
        [
            __DIR__.'/config',
            __DIR__.'/src',
        ],
        false
    )
    ->addPathsToExclude([
        __DIR__.'/tests',
        __DIR__.'/src/Support/Rectors',
    ])
    // ->ignoreErrorsOnExtensions(
    //     [
    //         'ext-mbstring',
    //     ],
    //     [ErrorType::SHADOW_DEPENDENCY]
    // )
    ->ignoreErrorsOnPackages(
        [
            'symfony/http-foundation',
            'symfony/http-kernel',
            'symfony/var-dumper',
        ],
        [ErrorType::SHADOW_DEPENDENCY]
    )
    ->ignoreErrorsOnPackages(
        [
            'guanguans/ai-commit',
        ],
        [ErrorType::DEV_DEPENDENCY_IN_PROD]
    );

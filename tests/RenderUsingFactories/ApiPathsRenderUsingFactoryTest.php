<?php

/** @noinspection DebugFunctionUsageInspection */

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\RenderUsingFactories\ApiPathsRenderUsingFactory;
use Illuminate\Support\Facades\File;

it('can return a JsonResponse', function (): void {
    $varExport = var_export(new ApiPathsRenderUsingFactory, true);
    File::put(
        $path = fixtures_path('ApiPathsRenderUsingFactory.php'),
        <<<PHP
            <?php

            /** @noinspection all */

            return $varExport;

            PHP
    );
    expect(require $path)->toBeInstanceOf(ApiPathsRenderUsingFactory::class);
})->group(__DIR__, __FILE__);

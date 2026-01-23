<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection DebugFunctionUsageInspection */
/** @noinspection UsingInclusionReturnValueInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\RenderUsings\ApiPathsRenderUsing;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

it('can call ApiPathsRenderUsing', function (): void {
    expect(ApiPathsRenderUsing::make(['*'])(new RuntimeException($this->faker()->title()), request()))
        ->toBeInstanceOf(JsonResponse::class);
})->group(__DIR__, __FILE__);

it('can set state for ApiPathsRenderUsing', function (): void {
    $varExport = var_export(ApiPathsRenderUsing::make(), true);
    File::put(
        $path = fixtures_path('ApiPathsRenderUsing.php'),
        <<<PHP
            <?php

            /** @noinspection all */

            return $varExport;

            PHP
    );
    expect(require $path)->toBeInstanceOf(ApiPathsRenderUsing::class);
})->group(__DIR__, __FILE__);

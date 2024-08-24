<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\RenderUsingFactories;

use Guanguans\LaravelApiResponse\Support\Traits\SetStateable;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;

class ApiPathsRenderUsingFactory extends RenderUsingFactory
{
    use SetStateable;

    /** @var list<string> */
    protected array $patternsPaths;

    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection MissingParentCallInspection
     */
    public function __construct(?array $patternsPaths = null)
    {
        $this->patternsPaths = $patternsPaths ?? $this->defaultPatternsPaths();
    }

    public function when(Request $request, \Throwable $throwable, ExceptionHandler $exceptionHandler): bool
    {
        return $request->is(...$this->patternsPaths);
    }

    protected function defaultPatternsPaths(): array
    {
        return ['api/*'];
    }
}

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

namespace Guanguans\LaravelApiResponse\RenderUsings;

use Guanguans\LaravelApiResponse\Support\Traits\MakeStaticable;
use Guanguans\LaravelApiResponse\Support\Traits\SetStateable;
use Illuminate\Http\Request;

class ApiPathsRenderUsing extends RenderUsing
{
    use MakeStaticable;
    use SetStateable;

    /** @var list<string> */
    protected array $only;

    public function __construct(
        ?array $only = null,
        /** @var list<string> */
        protected array $except = []
    ) {
        $this->only = $only ?? $this->defaultOnly();
    }

    protected function when(Request $request, \Throwable $throwable): bool
    {
        return $request->is(...$this->only) && !$request->is(...$this->except);
    }

    protected function defaultOnly(): array
    {
        return ['api/*'];
    }
}

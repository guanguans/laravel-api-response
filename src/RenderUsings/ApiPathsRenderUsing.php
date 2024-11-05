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

    /** @var list<string> */
    protected array $except;

    public function __construct(?array $only = null, array $except = [])
    {
        $this->only = $only ?? $this->defaultOnly();
        $this->except = $except;
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

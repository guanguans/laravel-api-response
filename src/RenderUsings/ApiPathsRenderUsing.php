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
    use SetStateable;
    use MakeStaticable;

    /** @var list<string> */
    protected array $paths;

    public function __construct(?array $paths = null)
    {
        $this->paths = $paths ?? $this->defaultPaths();
    }

    protected function when(Request $request, \Throwable $throwable): bool
    {
        return $request->is(...$this->paths);
    }

    protected function defaultPaths(): array
    {
        return ['api/*'];
    }
}

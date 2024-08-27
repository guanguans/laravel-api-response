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

namespace Guanguans\LaravelApiResponse\Tests\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @see \Guanguans\LaravelApiResponse\Tests\Models\User
 */
class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        // return [
        //     'data' => $this->collection,
        // ];

        return parent::toArray($request);
    }
}

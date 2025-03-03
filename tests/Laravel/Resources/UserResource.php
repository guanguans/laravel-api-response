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

namespace Guanguans\LaravelApiResponse\Tests\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Guanguans\LaravelApiResponse\Tests\Laravel\Models\User
 */
class UserResource extends JsonResource
{
    public function toArray(mixed $request): array
    {
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'country_id' => $this->country_id,
        //     'country' => $this->country,
        //     'posts' => $this->posts,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];

        return parent::toArray($request);
    }
}

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

namespace Guanguans\LaravelApiResponse\Tests\Laravel\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Guanguans\LaravelApiResponse\Tests\Laravel\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * @noinspection MissingParentCallInspection
     *
     * @param mixed $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'post' => $this->post,
            'posts' => $this->posts,
            'roles' => $this->roles,
        ];
    }
}

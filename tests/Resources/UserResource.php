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

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Guanguans\LaravelApiResponse\Tests\Models\User
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
            'posts_count' => $this->posts_count,
            'posts_with_offset_count' => $this->posts_with_offset_count,
            'roles_count' => $this->roles_count,
            'roles_with_offset_count' => $this->roles_with_offset_count,
        ];
    }
}

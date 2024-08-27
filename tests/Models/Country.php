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

namespace Guanguans\LaravelApiResponse\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Country extends Model
{
    public function post(): HasOneThrough
    {
        return $this->hasOneThrough(Post::class, User::class)->latest()->limit(1);
    }

    public function postWithOffset(): HasOneThrough
    {
        return $this->hasOneThrough(Post::class, User::class)->latest()->limit(1)->offset(1);
    }

    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, User::class)->latest()->take(2);
    }

    public function postsWithOffset(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, User::class)->latest()->take(2)->offset(1);
    }
}

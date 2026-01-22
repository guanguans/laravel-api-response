<?php

/** @noinspection PhpUnused */
/** @noinspection PhpMissingDocCommentInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Guanguans\LaravelApiResponse\Tests\Laravel\Models\User>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough<\Guanguans\LaravelApiResponse\Tests\Laravel\Models\Post>
     */
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, User::class);
    }
}

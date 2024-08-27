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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    public $timestamps = false;

    public function post(): HasOne
    {
        return $this->hasOne(Post::class)->latest()->limit(1);
    }

    public function postWithOffset(): HasOne
    {
        return $this->hasOne(Post::class)->latest();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->latest()->limit(2);
    }

    public function postsWithOffset(): HasMany
    {
        return $this->hasMany(Post::class)->latest()->limit(2)->offset(1);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->latest()->limit(2);
    }

    public function rolesWithOffset(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->latest()->limit(2)->offset(1);
    }
}

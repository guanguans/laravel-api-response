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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    public $timestamps = false;
    protected $casts = [
        'country_id' => 'int',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Guanguans\LaravelApiResponse\Tests\Laravel\Models\Country, \Guanguans\LaravelApiResponse\Tests\Laravel\Models\User>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Guanguans\LaravelApiResponse\Tests\Laravel\Models\Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

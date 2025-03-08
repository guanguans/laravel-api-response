<?php

/** @noinspection PhpUnused */
/** @noinspection PhpMissingDocCommentInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Post extends Model
{
    public $timestamps = false;
    protected $casts = [
        'user_id' => 'int',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\Guanguans\LaravelApiResponse\Tests\Laravel\Models\User, \Guanguans\LaravelApiResponse\Tests\Laravel\Models\Post>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough<\Guanguans\LaravelApiResponse\Tests\Laravel\Models\Country>
     */
    public function userCountry(): HasOneThrough
    {
        return $this->hasOneThrough(
            Country::class,
            User::class,
            'country_id',
            'id',
            'user_id',
            'country_id'
        );
    }
}

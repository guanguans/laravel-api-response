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

namespace Guanguans\LaravelApiResponse\Tests\Laravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    public $timestamps = false;
    protected $casts = [
        'user_id' => 'int',
    ];

    public function comment(): MorphOne
    {
        return $this->morphOne(Comment::class, 'commentable')->latest()->limit(1);
    }

    public function commentWithOffset(): MorphOne
    {
        return $this->morphOne(Comment::class, 'commentable')->latest()->limit(1)->offset(1);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->latest()->limit(2);
    }

    public function commentsWithOffset(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->latest()->limit(2)->offset(1);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->latest()->limit(2);
    }

    public function tagsWithOffset(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->latest()->limit(2)->offset(1);
    }
}

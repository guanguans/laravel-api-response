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

namespace Guanguans\LaravelApiResponse\Tests\Laravel\seeders;

use Guanguans\LaravelApiResponse\Tests\Laravel\Models\Comment;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\Country;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\Post;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\Role;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\Tag;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TablesSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        Country::query()->create();
        Country::query()->create();
        Country::query()->create();
        Country::query()->create();
        Country::query()->create();
        Country::query()->create();
        Country::query()->create();

        User::query()->create(['country_id' => 1]);
        User::query()->create(['country_id' => 2]);
        User::query()->create(['country_id' => 3]);
        User::query()->create(['country_id' => 4]);
        User::query()->create(['country_id' => 5]);
        User::query()->create(['country_id' => 6]);
        User::query()->create(['country_id' => 7]);

        Post::query()->create(['user_id' => 1, 'created_at' => new Carbon('2024-01-01 00:00:01')]);
        Post::query()->create(['user_id' => 1, 'created_at' => new Carbon('2024-01-01 00:00:02')]);
        Post::query()->create(['user_id' => 1, 'created_at' => new Carbon('2024-01-01 00:00:03')]);
        Post::query()->create(['user_id' => 2, 'created_at' => new Carbon('2024-01-01 00:00:04')]);
        Post::query()->create(['user_id' => 2, 'created_at' => new Carbon('2024-01-01 00:00:05')]);
        Post::query()->create(['user_id' => 2, 'created_at' => new Carbon('2024-01-01 00:00:06')]);
        Post::query()->create(['user_id' => 3, 'created_at' => new Carbon('2024-01-01 00:00:07')]);

        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 1, 'created_at' => new Carbon('2024-01-01 00:00:01')]);
        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 1, 'created_at' => new Carbon('2024-01-01 00:00:02')]);
        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 1, 'created_at' => new Carbon('2024-01-01 00:00:03')]);
        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 2, 'created_at' => new Carbon('2024-01-01 00:00:04')]);
        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 2, 'created_at' => new Carbon('2024-01-01 00:00:05')]);
        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 2, 'created_at' => new Carbon('2024-01-01 00:00:06')]);
        Comment::query()->create(['commentable_type' => Post::class, 'commentable_id' => 3, 'created_at' => new Carbon('2024-01-01 00:00:07')]);

        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:01')]);
        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:02')]);
        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:03')]);
        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:04')]);
        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:05')]);
        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:06')]);
        Role::query()->create(['created_at' => new Carbon('2024-01-01 00:00:07')]);

        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1],
            ['role_id' => 2, 'user_id' => 1],
            ['role_id' => 3, 'user_id' => 1],
            ['role_id' => 4, 'user_id' => 2],
            ['role_id' => 5, 'user_id' => 2],
            ['role_id' => 6, 'user_id' => 2],
            ['role_id' => 7, 'user_id' => 3],
        ]);

        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:01')]);
        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:02')]);
        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:03')]);
        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:04')]);
        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:05')]);
        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:06')]);
        Tag::query()->create(['created_at' => new Carbon('2024-01-01 00:00:07')]);

        DB::table('taggables')->insert([
            ['tag_id' => 1, 'taggable_type' => Post::class, 'taggable_id' => 1],
            ['tag_id' => 2, 'taggable_type' => Post::class, 'taggable_id' => 1],
            ['tag_id' => 3, 'taggable_type' => Post::class, 'taggable_id' => 1],
            ['tag_id' => 4, 'taggable_type' => Post::class, 'taggable_id' => 2],
            ['tag_id' => 5, 'taggable_type' => Post::class, 'taggable_id' => 2],
            ['tag_id' => 6, 'taggable_type' => Post::class, 'taggable_id' => 2],
            ['tag_id' => 7, 'taggable_type' => Post::class, 'taggable_id' => 3],
        ]);

        Model::reguard();
    }
}

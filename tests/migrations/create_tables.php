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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', static function (Blueprint $table): void {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('users', static function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('country_id');
        });

        Schema::create('posts', static function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });

        Schema::create('comments', static function (Blueprint $table): void {
            $table->increments('id');
            $table->morphs('commentable');
            $table->timestamps();
        });

        Schema::create('roles', static function (Blueprint $table): void {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('role_user', static function (Blueprint $table): void {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');
        });

        Schema::create('tags', static function (Blueprint $table): void {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('taggables', static function (Blueprint $table): void {
            $table->unsignedInteger('tag_id');
            $table->morphs('taggable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropAllTables();
    }
};

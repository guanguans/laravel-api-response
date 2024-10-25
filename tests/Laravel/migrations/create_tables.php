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
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('users', static function (Blueprint $table): void {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('country_id');
            $table->timestamps();
        });

        Schema::create('posts', static function (Blueprint $table): void {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropAllTables();
        Schema::dropIfExists('countries');
        Schema::dropIfExists('users');
        Schema::dropIfExists('posts');
    }
};

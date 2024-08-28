<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Guanguans\LaravelApiResponse\Tests\Laravel\Resources\UserResource;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

it('can return Model type data JSON response', function (): void {
    $user = User::query()->with('posts')->first();
    assertMatchesJsonSnapshot($this->apiResponse()->success($user)->content());
})->group(__DIR__, __FILE__);

it('can return Resource type data JSON response', function (): void {
    $userResource = UserResource::make(User::query()->with('posts')->first());
    assertMatchesJsonSnapshot($this->apiResponse()->success($userResource)->content());
})->group(__DIR__, __FILE__);

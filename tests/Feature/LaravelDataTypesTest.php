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

use Composer\Semver\Comparator;
use Guanguans\LaravelApiResponse\Tests\Laravel\Models\User;
use Guanguans\LaravelApiResponse\Tests\Laravel\Resources\UserCollection;
use Guanguans\LaravelApiResponse\Tests\Laravel\Resources\UserResource;
use Illuminate\Foundation\Application;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

it('can return Model type data JSON response', function (): void {
    $user = User::query()->with('posts')->first();
    assertMatchesJsonSnapshot($this->apiResponse()->success($user)->content());
})->group(__DIR__, __FILE__);

it('can return Collection type data JSON response', function (): void {
    $users = User::query()->with(['posts', 'roles'])->get();
    assertMatchesJsonSnapshot($this->apiResponse()->success($users)->content());
})->group(__DIR__, __FILE__);

it('can return paginate type data JSON response', function (): void {
    $users = User::query()->with(['posts', 'roles'])->paginate(3);
    assertMatchesJsonSnapshot($this->apiResponse()->success($users)->content());
})->group(__DIR__, __FILE__)->skip(Comparator::greaterThanOrEqualTo(Application::VERSION, '10.0.0'));

it('can return simplePaginate type data JSON response', function (): void {
    $users = User::query()->with(['posts', 'roles'])->simplePaginate(3);
    assertMatchesJsonSnapshot($this->apiResponse()->success($users)->content());
})->group(__DIR__, __FILE__);

it('can return cursorPaginate type data JSON response', function (): void {
    $users = User::query()->with(['posts', 'roles'])->cursorPaginate(3);
    assertMatchesJsonSnapshot($this->apiResponse()->success($users)->content());
})->group(__DIR__, __FILE__)->skip(Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0'));

it('can return Resource type data JSON response', function (): void {
    $userResource = UserResource::make(User::query()->with('posts')->first());
    assertMatchesJsonSnapshot($this->apiResponse()->success($userResource)->content());
})->group(__DIR__, __FILE__);

it('can return ResourceCollection type data JSON response', function (): void {
    $userCollection = UserCollection::make(User::query()->with(['posts', 'roles'])->get());
    assertMatchesJsonSnapshot($this->apiResponse()->success($userCollection)->content());
})->group(__DIR__, __FILE__);

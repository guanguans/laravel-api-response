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
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Fluent;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {
    // JsonResource::wrap('data');
    // JsonResource::wrap('list');
    // JsonResource::withoutWrapping();
});

it('is model', function (): void {
    $user = User::query()->with(['country', 'posts'])->first();
    assertMatchesJsonSnapshot($this->apiResponse()->success($user)->content());
})->group(__DIR__, __FILE__);

it('is eloquent collection', function (): void {
    $users = User::query()->with(['country', 'posts'])->get();
    assertMatchesJsonSnapshot($this->apiResponse()->success($users)->content());
})->group(__DIR__, __FILE__);

it('is paginate', function (): void {
    $paginate = User::query()->with(['country', 'posts'])->paginate(3);
    assertMatchesJsonSnapshot($this->apiResponse()->success($paginate)->content());
})->group(__DIR__, __FILE__)->skip(Comparator::greaterThanOrEqualTo(Application::VERSION, '10.0.0'));

it('is simple paginate', function (): void {
    $simplePaginate = User::query()->with(['country', 'posts'])->simplePaginate(3);
    assertMatchesJsonSnapshot($this->apiResponse()->success($simplePaginate)->content());
})->group(__DIR__, __FILE__);

it('is cursor paginate', function (): void {
    $cursorPaginate = User::query()->with(['country', 'posts'])->cursorPaginate(3);
    assertMatchesJsonSnapshot($this->apiResponse()->success($cursorPaginate)->content());
})->group(__DIR__, __FILE__)->skip(Comparator::greaterThanOrEqualTo(Application::VERSION, '9.0.0'));

it('is resource', function (): void {
    $userResource = UserResource::make(User::query()->with(['country', 'posts'])->first());
    assertMatchesJsonSnapshot($this->apiResponse()->success($userResource)->content());

    JsonResource::withoutWrapping();
    assertMatchesJsonSnapshot($this->apiResponse()->success($userResource)->content());
})->group(__DIR__, __FILE__);

it('is resource collection', function (): void {
    $userCollection = UserCollection::make(User::query()->with(['country', 'posts'])->get());
    assertMatchesJsonSnapshot($this->apiResponse()->success($userCollection)->content());

    $userCollection = UserCollection::make(User::query()->with(['country', 'posts'])->simplePaginate(3));
    assertMatchesJsonSnapshot($this->apiResponse()->success($userCollection)->content());
})->group(__DIR__, __FILE__);

it('is collection', function (): void {
    $collection = collect([
        'name' => 'guanguans/laravel-api-response',
        'license' => 'MIT',
        'type' => 'library',
        'authors' => [
            [
                'name' => 'guanguans',
                'email' => 'ityaozm@gmail.com',
                'homepage' => 'https://www.guanguans.cn',
                'role' => 'developer',
            ],
        ],
        'homepage' => 'https://github.com/guanguans/laravel-api-response',
        'support' => [
            'issues' => 'https://github.com/guanguans/laravel-api-response/issues',
            'source' => 'https://github.com/guanguans/laravel-api-response',
        ],
    ]);
    assertMatchesJsonSnapshot($this->apiResponse()->success($collection)->content());
})->group(__DIR__, __FILE__);

it('is fluent', function (): void {
    $fluent = new Fluent([
        'name' => 'guanguans/laravel-api-response',
        'license' => 'MIT',
        'type' => 'library',
        'authors' => [
            [
                'name' => 'guanguans',
                'email' => 'ityaozm@gmail.com',
                'homepage' => 'https://www.guanguans.cn',
                'role' => 'developer',
            ],
        ],
        'homepage' => 'https://github.com/guanguans/laravel-api-response',
        'support' => [
            'issues' => 'https://github.com/guanguans/laravel-api-response/issues',
            'source' => 'https://github.com/guanguans/laravel-api-response',
        ],
    ]);
    assertMatchesJsonSnapshot($this->apiResponse()->success($fluent)->content());
})->group(__DIR__, __FILE__);

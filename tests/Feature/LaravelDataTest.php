<?php

/** @noinspection JsonEncodingApiUsageInspection */
/** @noinspection PhpMissingDocCommentInspection */
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
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
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

    JsonResource::wrap('data');
    assertMatchesJsonSnapshot($this->apiResponse()->success($userResource)->content());
})->group(__DIR__, __FILE__);

it('is resource collection', function (): void {
    $userCollection = UserCollection::make(User::query()->with(['country', 'posts'])->get());
    assertMatchesJsonSnapshot($this->apiResponse()->success($userCollection)->content());

    $userCollection = UserCollection::make(User::query()->with(['country', 'posts'])->simplePaginate(3));
    assertMatchesJsonSnapshot($this->apiResponse()->success($userCollection)->content());
})->group(__DIR__, __FILE__);

it('is responsable', function (array $array): void {
    $responsable = new class($array) implements Responsable {
        private array $array;

        public function __construct(array $array)
        {
            $this->array = $array;
        }

        public function toResponse($request): JsonResponse
        {
            return response()->json($this->array);
        }
    };
    assertMatchesJsonSnapshot($this->apiResponse()->success($responsable)->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is stringable', function (array $array): void {
    $stringable = Str::of(json_encode($array));
    assertMatchesJsonSnapshot($this->apiResponse()->success($stringable)->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is arrayable', function (array $array): void {
    $arrayable = new class($array) implements Arrayable {
        private array $array;

        public function __construct(array $array)
        {
            $this->array = $array;
        }

        public function toArray(): array
        {
            return $this->array;
        }
    };
    assertMatchesJsonSnapshot($this->apiResponse()->success($arrayable)->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is jsonable', function (array $array): void {
    $jsonable = new class($array) implements Jsonable {
        private array $array;

        public function __construct(array $array)
        {
            $this->array = $array;
        }

        public function toJson($options = 0)
        {
            return json_encode($this->array, $options);
        }
    };
    assertMatchesJsonSnapshot($this->apiResponse()->success($jsonable)->content());
})->group(__DIR__, __FILE__)->with('arrays');

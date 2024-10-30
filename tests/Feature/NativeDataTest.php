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

use Illuminate\Http\Resources\Json\JsonResource;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {
    // JsonResource::wrap('data');
    // JsonResource::wrap('list');
    // JsonResource::withoutWrapping();
});

/** @see https://www.php.net/manual/en/language.types.php */
it('is null', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(null)->content());
})->group(__DIR__, __FILE__);

it('is boolean', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(true)->content());
})->group(__DIR__, __FILE__);

it('is integer', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(1)->content());
})->group(__DIR__, __FILE__);
it('is float', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(1.1)->content());
})->group(__DIR__, __FILE__);
it('is string', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success('string')->content());
})->group(__DIR__, __FILE__);

it('is array', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(['foo', 'bar', 'baz'])->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])->content());
})->group(__DIR__, __FILE__);

it('is object', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((object) [
        'name' => 'guanguans/laravel-api-response',
        'license' => 'MIT',
        'type' => 'library',
    ])->content());
})->group(__DIR__, __FILE__);

it('is enum', function (): void {
    // enum Suit
    // {
    //     case Hearts;
    //     case Diamonds;
    //     case Clubs;
    //     case Spades;
    // }

    assertMatchesJsonSnapshot($this->apiResponse()->success(Suit::Hearts)->content());
})->group(__DIR__, __FILE__)->skip(\PHP_VERSION_ID < 80100 ? 'Enum type data is not supported' : '');
it('is resource', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(fopen(__FILE__, 'rb'))->content());
})->group(__DIR__, __FILE__)->throws(\InvalidArgumentException::class, 'Type is not supported');

it('is callable', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(fn (): string => 'callable')->content());
})->group(__DIR__, __FILE__);

it('is iterable', function (): void {
    /** @see \ArrayAccess */
    assertMatchesJsonSnapshot($this->apiResponse()->success(new ArrayIterator([
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
    ]))->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(new FilesystemIterator(__DIR__))->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(new GlobIterator(__DIR__.'/*'))->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success((function () {
        foreach (glob(__DIR__.'/*') as $file) {
            yield $file;
        }
    })())->content());
})->group(__DIR__, __FILE__);

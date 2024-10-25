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
    // JsonResource::$wrap = 'data';
    // JsonResource::$wrap = 'list';
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
    assertMatchesJsonSnapshot($this->apiResponse()->success(['array'])->content());
})->group(__DIR__, __FILE__);

it('is object', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((object) ['object' => 'object'])->content());
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
    assertMatchesJsonSnapshot($this->apiResponse()->success(new ArrayIterator(['iterable']))->content());
})->group(__DIR__, __FILE__);

it('is generator', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((function () {
        yield 'generator';
    })())->content());
})->group(__DIR__, __FILE__);

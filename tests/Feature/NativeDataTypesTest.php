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

use function Spatie\Snapshots\assertMatchesJsonSnapshot;

/** @see https://www.php.net/manual/en/language.types.php */
it('can return null type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(null)->content());
})->group(__DIR__, __FILE__);

it('can return boolean type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(true)->content());
})->group(__DIR__, __FILE__);

it('can return integer type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(1)->content());
})->group(__DIR__, __FILE__);
it('can return float type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(1.1)->content());
})->group(__DIR__, __FILE__);
it('can return string type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success('string')->content());
})->group(__DIR__, __FILE__);

it('can return array type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(['array'])->content());
})->group(__DIR__, __FILE__);

it('can return object type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((object) ['object' => 'object'])->content());
})->group(__DIR__, __FILE__);

it('can return enum type data JSON response', function (): void {
    // enum Suit
    // {
    //     case Hearts;
    //     case Diamonds;
    //     case Clubs;
    //     case Spades;
    // }

    assertMatchesJsonSnapshot($this->apiResponse()->success(Suit::Hearts)->content());
})->group(__DIR__, __FILE__)->skip(\PHP_VERSION_ID < 80100 ? 'Enum type data is not supported' : '');
it('can return resource type data JSON response', function (): void {
    /** @noinspection PhpComposerExtensionStubsInspection */
    assertMatchesJsonSnapshot($this->apiResponse()->success(curl_init())->content());
})->group(__DIR__, __FILE__)->skip('Resource type data is not supported');

it('can return callable type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(fn (): string => 'callable')->content());
})->group(__DIR__, __FILE__)->skip('Callable type data is not supported');

it('can return iterable type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(new ArrayIterator(['iterable']))->content());
})->group(__DIR__, __FILE__)->skip('Iterable type data is not supported');

it('can return generator type data JSON response', function (): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((function () {
        yield 'generator';
    })())->content());
})->group(__DIR__, __FILE__)->skip('Generator type data is not supported');

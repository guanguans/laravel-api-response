<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection JsonEncodingApiUsageInspection */
/** @noinspection PhpUnusedAliasInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

use Guanguans\LaravelApiResponseTests\Fixtures\NativeDataTest;
use Guanguans\LaravelApiResponseTests\Fixtures\Suit;

beforeEach(function (): void {});

/** @see https://www.php.net/manual/en/language.types.php */
it('is null', function (string $language): void {
    config()->set('app.locale', $language);
    expect($this->apiResponse()->success())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('languages');

it('is boolean', function (): void {
    expect($this->apiResponse()->success(true))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is integer', function (): void {
    expect($this->apiResponse()->success(1))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is float', function (): void {
    expect($this->apiResponse()->success(1.1))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is string', function (): void {
    expect($this->apiResponse()->success('string'))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is array', function (): void {
    expect($this->apiResponse()->success(['foo', 'bar', 'baz']))->toMatchSnapshot();
    expect($this->apiResponse()->success(['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz']))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is object', function (array $array): void {
    expect($this->apiResponse()->success((object) $array))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is enum', function (): void {
    expect($this->apiResponse()->success(Suit::HEART))->toMatchSnapshot();
    expect($this->apiResponse()->success(Suit::cases()))->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is resource', function (): void {
    expect($this->apiResponse()->success(fopen(__FILE__, 'rb')))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'Type is not supported');

it('is callable', function (): void {
    expect($this->apiResponse()->success(fn (): string => __METHOD__))->toMatchSnapshot();
    expect($this->apiResponse()->success('\time'))->toMatchSnapshot(); // unsupported
    expect($this->apiResponse()->success(NativeDataTest::staticMethod(...)))->toMatchSnapshot();
    expect($this->apiResponse()->success(NativeDataTest::class.'::staticMethod'))->toMatchSnapshot();
    expect($this->apiResponse()->success([NativeDataTest::make(), 'generalMethod']))->toMatchSnapshot();
    expect($this->apiResponse()->success(NativeDataTest::make()))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->skip(\PHP_VERSION_ID >= 80400, 'Closure type data is not compatible with PHP 8.4');

it('is iterable', function (array $array): void {
    // FilesystemIterator is not sorted on php lower versions.
    expect($this->apiResponse()->success(new FilesystemIterator(__DIR__)))->toMatchSnapshot();
    expect($this->apiResponse()->success(new GlobIterator(__DIR__.'/*')))->toMatchSnapshot();
    expect($this->apiResponse()->success(
        (function () use ($array) {
            foreach ($array as $key => $value) {
                yield $key => $value;
            }
        })()
    ))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is array object', function (array $array): void {
    expect($this->apiResponse()->success(new ArrayObject($array)))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is std class', function (array $array): void {
    expect($this->apiResponse()->success((object) $array))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is json serializable', function (array $array): void {
    expect($this->apiResponse()->success(
        new class($array) implements JsonSerializable {
            public function __construct(private readonly array $array) {}

            public function jsonSerialize(): array
            {
                return $this->array;
            }
        }
    ))->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

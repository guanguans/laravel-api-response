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

use Guanguans\LaravelApiResponse\Support\Traits\MakeStaticable;

beforeEach(function (): void {});

/** @see https://www.php.net/manual/en/language.types.php */
it('is null', function (string $language): void {
    config()->set('app.locale', $language);
    expect($this->apiResponse()->success()->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('languages');

it('is boolean', function (): void {
    expect($this->apiResponse()->success(true)->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is integer', function (): void {
    expect($this->apiResponse()->success(1)->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is float', function (): void {
    expect($this->apiResponse()->success(1.1)->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is string', function (): void {
    expect($this->apiResponse()->success('string')->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is array', function (): void {
    expect($this->apiResponse()->success(['foo', 'bar', 'baz'])->content())->toMatchSnapshot();
    expect($this->apiResponse()->success(['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'])->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is object', function (array $array): void {
    expect($this->apiResponse()->success((object) $array)->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is enum', function (): void {
    enum Suit: string
    {
        case HEART = '♥︎';
        case DIAMOND = '♦︎';
        case CLUB = '♣︎';
        case SPADE = '︎♠︎';
    }

    expect($this->apiResponse()->success(Suit::HEART)->content())->toMatchSnapshot();
    expect($this->apiResponse()->success(Suit::cases())->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__);

it('is resource', function (): void {
    expect($this->apiResponse()->success(fopen(__FILE__, 'rb'))->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'Type is not supported');

it('is callable', function (): void {
    class NativeDataTest
    {
        use MakeStaticable;

        public function __invoke(): string
        {
            return __METHOD__;
        }

        public static function staticMethod(): string
        {
            return __METHOD__;
        }

        public function generalMethod(): string
        {
            return __METHOD__;
        }
    }

    expect($this->apiResponse()->success(fn (): string => __METHOD__)->content())->toMatchSnapshot();
    expect($this->apiResponse()->success('\time')->content())->toMatchSnapshot(); // unsupported
    expect($this->apiResponse()->success(NativeDataTest::staticMethod(...))->content())->toMatchSnapshot();
    expect($this->apiResponse()->success(NativeDataTest::class.'::staticMethod')->content())->toMatchSnapshot();
    expect($this->apiResponse()->success([NativeDataTest::make(), 'generalMethod'])->content())->toMatchSnapshot();
    expect($this->apiResponse()->success(NativeDataTest::make())->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->skip(\PHP_VERSION_ID >= 80400, 'Closure type data is not compatible with PHP 8.4');

it('is iterable', function (array $array): void {
    // // FilesystemIterator is not sorted on php lower versions.
    // expect(
    //     (string) str($this->apiResponse()->success(new FilesystemIterator(__DIR__))->content())
    //         ->remove($basePath = trim(json_encode(\dirname(__DIR__, 2), \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES), '"'))
    // )->toMatchSnapshot();
    expect(
        (string) str($this->apiResponse()->success(new GlobIterator(__DIR__.'/*'))->content())
            ->remove(trim(json_encode(\dirname(__DIR__, 2), \JSON_THROW_ON_ERROR | \JSON_UNESCAPED_SLASHES), '"'))
    )->toMatchSnapshot();
    expect(
        $this->apiResponse()->success(
            (function () use ($array) {
                foreach ($array as $key => $value) {
                    yield $key => $value;
                }
            })()
        )->content()
    )->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is array object', function (array $array): void {
    expect($this->apiResponse()->success(new ArrayObject($array))->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is std class', function (array $array): void {
    expect($this->apiResponse()->success((object) $array)->content())->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

it('is json serializable', function (array $array): void {
    expect(
        $this->apiResponse()->success(
            new class($array) implements JsonSerializable {
                public function __construct(private readonly array $array) {}

                public function jsonSerialize(): array
                {
                    return $this->array;
                }
            }
        )->content()
    )->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('arrays');

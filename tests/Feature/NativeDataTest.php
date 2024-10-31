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

use Guanguans\LaravelApiResponse\Support\Macros\CollectionMacro;
use Guanguans\LaravelApiResponse\Support\Utils;
use Illuminate\Http\Resources\Json\JsonResource;
use function Spatie\Snapshots\assertMatchesJsonSnapshot;

beforeEach(function (): void {
    // JsonResource::wrap('data');
    // JsonResource::wrap('list');
    // JsonResource::withoutWrapping();
});

/** @see https://www.php.net/manual/en/language.types.php */
it('is null', function (string $language): void {
    config()->set('app.locale', $language);
    assertMatchesJsonSnapshot($this->apiResponse()->success()->content());
})->group(__DIR__, __FILE__)->with('languages');

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

it('is object', function (array $array): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((object) $array)->content());
})->group(__DIR__, __FILE__)->with('arrays');

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
    assertMatchesJsonSnapshot($this->apiResponse()->success('\make')->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success([Utils::class, 'statusCodeFor'])->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(Utils::class.'::statusCodeFor')->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success([new CollectionMacro, 'unshift'])->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(
        new class {
            public function __invoke(): string
            {
                return 'callable';
            }
        }
    )->content());
})->group(__DIR__, __FILE__);

it('is iterable', function (array $array): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(new FilesystemIterator(__DIR__))->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(new GlobIterator(__DIR__.'/*'))->content());
    assertMatchesJsonSnapshot($this->apiResponse()->success(
        (function () use ($array) {
            foreach ($array as $key => $value) {
                yield $key => $value;
            }
        })()
    )->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is array object', function (array $array): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(new ArrayObject($array))->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is std class', function (array $array): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success((object) $array)->content());
})->group(__DIR__, __FILE__)->with('arrays');

it('is json serializable', function (array $array): void {
    assertMatchesJsonSnapshot($this->apiResponse()->success(
        new class($array) implements JsonSerializable {
            private array $array;

            public function __construct(array $array)
            {
                $this->array = $array;
            }

            public function jsonSerialize(): array
            {
                return $this->array;
            }
        }
    )->content());
})->group(__DIR__, __FILE__)->with('arrays');

<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Support\Rector;

use Guanguans\LaravelApiResponse\Concerns\ConcreteHttpStatus;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Trait_;
use Rector\Rector\AbstractRector;
use Symfony\Component\HttpFoundation\Response;
use function Guanguans\RectorRules\Support\clone_node;

class ConcreteHttpStatusRector extends AbstractRector
{
    public function getNodeTypes(): array
    {
        return [
            Trait_::class,
        ];
    }

    /**
     * @param \PhpParser\Node\Stmt\Trait_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node, ConcreteHttpStatus::class)) {
            return null;
        }

        $reflectionClass = new \ReflectionClass(Response::class);
        $methods = collect($reflectionClass->getConstants(\ReflectionClassConstant::IS_PUBLIC))
            ->filter(
                static fn (int $statusCode, string $statusName): bool => !$node->getMethod(
                    str($statusName)
                        ->replaceFirst('HTTP_', '')
                        ->lower()
                        ->camel()
                        ->toString()
                ) && 400 <= $statusCode && 500 > $statusCode
            )
            ->map(static function (int $_, string $statusName) use ($node): Node {
                $classMethod = clone_node($node->getMethod('unauthorized'));
                $classMethod->name->name = str($statusName)
                    ->replaceFirst('HTTP_', '')
                    ->lower()
                    ->camel()
                    ->toString();

                /** @phpstan-ignore-next-line */
                $classMethod->stmts[0]->expr->args[1]->value->name->name = $statusName;

                return $classMethod;
            });

        if ($methods->isEmpty()) {
            return null;
        }

        $statusNames = collect($reflectionClass->getConstants(\ReflectionClassConstant::IS_PUBLIC))
            ->sort()
            ->keys()
            ->map(
                static fn (string $statusName) => str($statusName)
                    ->replaceFirst('HTTP_', '')
                    ->lower()
                    ->camel()
                    ->toString()
            );

        $node->stmts = collect($node->stmts)
            ->merge($methods)
            ->sort(
                fn (ClassMethod $a, ClassMethod $b): int => $statusNames->search($this->getName($a), true)
                    <=> $statusNames->search($this->getName($b), true)
            )
            ->all();

        return $node;
    }
}

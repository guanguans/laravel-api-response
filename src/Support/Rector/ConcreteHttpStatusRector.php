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
use Illuminate\Support\Collection;
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
            ->reduce(
                static function (Collection $classMethodNodes, int $statusCode, string $statusName) use ($node): Collection {
                    $methodName = str($statusName)
                        ->replaceFirst('HTTP_', '')
                        ->lower()
                        ->camel()
                        ->toString();

                    if (
                        200 > $statusCode
                        || 500 <= $statusCode
                        || \in_array($statusCode, [Response::HTTP_OK, Response::HTTP_NO_CONTENT, Response::HTTP_BAD_REQUEST], true)
                        || $node->getMethod($methodName)
                    ) {
                        return $classMethodNodes;
                    }

                    $classMethodNode = clone_node($node->getMethod('unauthorized'));
                    $classMethodNode->name->name = $methodName;

                    /** @phpstan-ignore-next-line */
                    $classMethodNode->stmts[0]->expr->args[1]->value->name->name = $statusName;

                    return $classMethodNodes->push($classMethodNode);
                },
                collect()
            );

        if ($methods->isEmpty()) {
            return null;
        }

        $statusNames = collect($reflectionClass->getConstants(\ReflectionClassConstant::IS_PUBLIC));
        $newStmtNodes = collect($node->stmts)
            // ->merge($methods)
            ->sort(
                fn (
                    ClassMethod $a,
                    ClassMethod $b
                ): int => $statusNames->get(str($this->getName($a))->snake()->start('HTTP_')->upper()->toString())
                    <=> $statusNames->get(str($this->getName($b))->snake()->start('HTTP_')->upper()->toString())
            )
            ->all();

        if ($node->stmts === $newStmtNodes) {
            return null;
        }

        $node->stmts = $newStmtNodes;

        return $node;
    }
}

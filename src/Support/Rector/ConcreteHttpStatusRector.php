<?php

/** @noinspection EfferentObjectCouplingInspection */

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
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Trait_;
use Rector\Rector\AbstractRector;
use Symfony\Component\HttpFoundation\Response;
use function Guanguans\RectorRules\Support\clone_node;

class ConcreteHttpStatusRector extends AbstractRector
{
    private const SPECIAL_STATUS_NAMES = [
        'HTTP_OK', // 200
        'HTTP_CREATED', // 201
        'HTTP_ACCEPTED', // 202
        'HTTP_NO_CONTENT', // 204
        'HTTP_BAD_REQUEST', // 400
    ];

    /**
     * @return list<class-string<\PhpParser\Node>>
     */
    public function getNodeTypes(): array
    {
        return [
            Trait_::class,
        ];
    }

    /**
     * @param \PhpParser\Node\Stmt\Trait_ $node
     *
     * @noinspection NullPointerExceptionInspection
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->isName($node, ConcreteHttpStatus::class)) {
            return null;
        }

        /** @var list<ClassMethod> $newStmtNodes */
        $newStmtNodes = collect((new \ReflectionClass(Response::class))->getConstants(\ReflectionClassConstant::IS_PUBLIC))
            ->tap(static function (Collection $rawStatuses) use (&$statuses): void {
                $statuses = $rawStatuses;
            })
            ->reduce(
                function (Collection $classMethodNodes, int $statusCode, string $statusName) use ($node): Collection {
                    $response = new Response(status: $statusCode);

                    if (
                        $response->isInvalid()
                        || $response->isInformational()
                        || $response->isRedirection()
                        || $response->isServerError()
                        || $response->isRedirect()
                        || $response->isEmpty()
                        || \in_array($statusName, self::SPECIAL_STATUS_NAMES, true)
                    ) {
                        return $classMethodNodes;
                    }

                    return $classMethodNodes->push($this->makeClassMethodNode($node, $response, $statusName));
                },
                collect(array_map(
                    fn (string $statusName): ClassMethod => $node->getMethod($this->parseMethodName($statusName)),
                    self::SPECIAL_STATUS_NAMES
                ))
            )
            ->sort(
                fn (
                    ClassMethod $a,
                    ClassMethod $b
                ): int => (int) $statuses->get(str($this->getName($a))->snake()->start('HTTP_')->upper()->toString())
                    <=> (int) $statuses->get(str($this->getName($b))->snake()->start('HTTP_')->upper()->toString())
            )
            ->values()
            ->all();

        if ($node->stmts === $newStmtNodes) {
            return null;
        }

        $node->stmts = $newStmtNodes;

        return $node;
    }

    private function makeClassMethodNode(Trait_ $traitNode, Response $response, string $statusName): ClassMethod
    {
        return match (true) {
            $response->isSuccessful() => $this->rawMakeClassMethodNode($traitNode, $statusName, 'accepted'),
            $response->isClientError() => $this->rawMakeClassMethodNode($traitNode, $statusName, 'badRequest'),
            default => throw new \LogicException("Unsupported status code [{$response->getStatusCode()}]."),
        };
    }

    /**
     * @param non-empty-string $statusName
     */
    private function rawMakeClassMethodNode(Trait_ $traitNode, string $statusName, string $prototypeMethodName): ClassMethod
    {
        $argPositionRules = ['accepted' => 2, 'badRequest' => 1];
        \assert(\array_key_exists($prototypeMethodName, $argPositionRules));

        $classMethodNode = $traitNode->getMethod($prototypeMethodName);
        \assert($classMethodNode instanceof ClassMethod);

        $classMethodNode = clone_node($classMethodNode);
        $classMethodNode->name->name = $this->parseMethodName($statusName);

        $returnNode = $classMethodNode->stmts[0] ?? null;
        \assert($returnNode instanceof Return_);

        $methodCallNode = $returnNode->expr;
        \assert($methodCallNode instanceof MethodCall);

        $argNode = $methodCallNode->getArg('code', $argPositionRules[$prototypeMethodName]);
        \assert($argNode instanceof Arg);

        $classConstFetchNode = $argNode->value;
        \assert($classConstFetchNode instanceof ClassConstFetch);

        $identifierNode = $classConstFetchNode->name;
        \assert($identifierNode instanceof Identifier);

        $identifierNode->name = $statusName;

        return $classMethodNode;
    }

    /**
     * @return non-empty-string
     */
    private function parseMethodName(string $statusName): string
    {
        return str($statusName)
            // ->chopStart('HTTP_')
            ->replaceStart('HTTP_', '')
            ->lower()
            ->camel()
            ->toString();
    }
}

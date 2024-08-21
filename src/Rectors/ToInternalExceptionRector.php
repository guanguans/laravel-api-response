<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-api-response
 */

namespace Guanguans\LaravelApiResponse\Rectors;

use Illuminate\Support\Str;
use PhpParser\Node;
use PhpParser\Node\Name;
use Rector\Contract\Rector\ConfigurableRectorInterface;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Exception\PoorDocumentationException;
use Symplify\RuleDocGenerator\Exception\ShouldNotHappenException;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Webmozart\Assert\Assert;

/**
 * @internal
 */
final class ToInternalExceptionRector extends AbstractRector implements ConfigurableRectorInterface
{
    private array $except = [];

    /**
     * @throws PoorDocumentationException
     * @throws ShouldNotHappenException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'To internal exception',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
                        throw new \InvalidArgumentException('on_headers must be callable');
                        CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
                        throw new \Guanguans\LaravelApiResponse\Exceptions\InvalidArgumentException('on_headers must be callable');
                        CODE_SAMPLE,
                    ['exceptionClassPattern' => 'exceptionClassPattern'],
                ),
            ],
        );
    }

    public function configure(array $configuration): void
    {
        Assert::allStringNotEmpty($configuration);
        $this->except = array_merge($this->except, $configuration);
    }

    public function getNodeTypes(): array
    {
        return [
            Node\Expr\New_::class,
        ];
    }

    /**
     * @param Node\Expr\New_ $node
     *
     * @throws \ReflectionException
     */
    public function refactor(Node $node)
    {
        $class = $node->class;

        if (
            !$class instanceof Name
            || Str::is($this->except, $class->toString())
            || 0 === strncmp(
                $class->toString(),
                'Guanguans\\LaravelApiResponse\\Exceptions\\',
                \strlen('Guanguans\\LaravelApiResponse\\Exceptions\\'),
            )
            || 0 !== substr_compare($class->toString(), 'Exception', -\strlen('Exception'))
        ) {
            return;
        }

        $internalExceptionClass = "\\Guanguans\\LaravelApiResponse\\Exceptions\\{$class->getLast()}";

        if (!class_exists($internalExceptionClass)) {
            $this->createInternalException($class);
        }

        $node->class = new Name($internalExceptionClass, $class->getAttributes());

        return $node;
    }

    /**
     * @throws \ReflectionException
     */
    private function createInternalException(Name $name): void
    {
        $externalExceptionClass = $name->toString();
        $reflectionClass = new \ReflectionClass($externalExceptionClass);

        if ($reflectionClass->isFinal()) {
            return;
        }

        $file = __DIR__."/../Exceptions/{$name->getLast()}.php";

        /** @noinspection MkdirRaceConditionInspection */
        is_dir($dir = \dirname($file)) or mkdir($dir, 0755, true);

        file_put_contents(
            $file,
            <<<PHP
                <?php

                declare(strict_types=1);

                namespace Guanguans\\LaravelApiResponse\\Exceptions;

                use Guanguans\\LaravelApiResponse\\Contracts\\Throwable;

                class {$name->getLast()} extends \\$externalExceptionClass implements Throwable {}

                PHP
        );
    }
}

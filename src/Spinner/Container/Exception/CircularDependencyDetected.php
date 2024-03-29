<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Exception;

use ArrayObject;
use Throwable;

/**
 * @codeCoverageIgnore
 */
final class CircularDependencyDetected extends ContainerException
{
    public function __construct(ArrayObject $dependencyStack, ?Throwable $previous = null)
    {
        $message = 'Circular dependency detected!' . $this->formatStack($dependencyStack);
        parent::__construct($message, previous: $previous);
    }

    private function formatStack(ArrayObject $stack): string
    {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        return PHP_EOL . implode(' ➜ ', $stack->getArrayCopy());
    }
}

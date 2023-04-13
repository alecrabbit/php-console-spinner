<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Exception;

use ArrayObject;
use Throwable;

/**
 * @codeCoverageIgnore
 */
final class CircularDependencyException extends ContainerException
{
    public function __construct(ArrayObject $dependencyStack, int $code = 0, ?Throwable $previous = null)
    {
        $message = 'Circular dependency detected!' . $this->formatStack($dependencyStack);
        parent::__construct($message, $code, $previous);
    }

    private function formatStack(ArrayObject $stack): string
    {
        return PHP_EOL . implode(' ➜ ', $stack->getArrayCopy());
    }
}

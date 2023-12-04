<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container;

use AlecRabbit\Spinner\Container\Contract\ICircularDependencyDetector;
use AlecRabbit\Spinner\Container\Exception\CircularDependencyDetected;
use ArrayObject;

use function in_array;

final readonly class CircularDependencyDetector implements ICircularDependencyDetector
{
    public function __construct(
        private ArrayObject $stack = new ArrayObject(),
    ) {
    }

    public function push(string $id): void
    {
        if (in_array($id, $this->stack->getArrayCopy(), true)) {
            throw new CircularDependencyDetected($this->stack);
        }

        $this->stack->append($id);
    }

    public function pop(): void
    {
        $key = array_key_last($this->stack->getArrayCopy());

        if ($key !== null && $this->stack->offsetExists($key)) {
            $this->stack->offsetUnset($key);
        }
    }
}

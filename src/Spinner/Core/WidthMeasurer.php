<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Closure;
use ReflectionFunction;

final class WidthMeasurer implements IWidthMeasurer
{
    public function __construct(
        protected Closure $measureFunction,
    ) {
        self::assert($this->measureFunction);
    }

    protected static function assert(Closure $measureFunction): void
    {
        $reflection = new ReflectionFunction($measureFunction);
        $returnType = $reflection->getReturnType()?->getName();
        $parameters = $reflection->getParameters();
        $parameterType = $parameters[0]->getType()?->getName();
        $count = count($parameters);

        if (1 === $count && 'string' === $parameterType && 'int' === $returnType) {
            return;
        }

        throw new InvalidArgumentException(
            'Invalid measure function signature. It should be: "function(string $string): int {...}".'
        );
    }

    public function getWidth(string $string): int
    {
        return (int)($this->measureFunction)($string);
    }
}

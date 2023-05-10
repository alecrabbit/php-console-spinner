<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use Closure;
use ReflectionFunction;

final class WidthMeasurer implements IWidthMeasurer
{
    public function __construct(
        protected Closure $measureFunction,
    ) {
        self::assert($this->measureFunction);
    }

    private static function assert(Closure $measureFunction): void
    {
        $reflection = new ReflectionFunction($measureFunction);
        $returnType = $reflection->getReturnType()?->getName();
        $parameterType = $reflection->getParameters()[0]->getType()?->getName();

        if ($parameterType === 'string' && $returnType === 'int') {
            return;
        }

        throw new InvalidArgumentException(
            'Invalid measure function signature.'
            . ' Signature expected to be: "function(string $string): int { //... }".'
        );
    }

    public function measureWidth(string $string): int
    {
        return (int)($this->measureFunction)($string);
    }
}

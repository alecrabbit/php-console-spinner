<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use Closure;

final class WidthMeasurer implements IWidthMeasurer
{
    public function __construct(
        protected Closure $measureFunction,
    ) {
        self::assert($this->measureFunction);
    }

    protected static function assert(Closure $measureFunction): void
    {
        // TODO (2023-04-04 14:18) [Alec Rabbit]: assert signature

        // // validate function has this signature: function(string $string): int
        // // example:
        // $reflection = new ReflectionFunction($measureFunction);
        // $parameters = $reflection->getParameters();
        // $returnType = $reflection->getReturnType();
        // if (
        //     1 !== count($parameters)
        //     || 'string' !== $parameters[0]->getType()
        //     || 'int' !== $returnType
        // ) {
        //     throw new InvalidArgumentException(
        //         'Invalid measure function signature. It should be: function(string $string): int'
        //     );
        // }


    }

    public function getWidth(string $string): int
    {
        return (int)($this->measureFunction)($string);
    }
}

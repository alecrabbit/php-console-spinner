<?php
declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use Closure;

final class Determiner implements IDeterminer
{
    public function __construct(
        protected Closure $determinerFunc,
    ) {
        self::assert($this->determinerFunc);
    }

    protected static function assert(Closure $determinerFunc): void
    {
        // assert signature
    }

    public function getWidth(string $string): int
    {
        return (int)($this->determinerFunc)($string);
    }
}
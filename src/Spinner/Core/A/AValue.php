<?php
declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Contract\IValue;

abstract class AValue implements IValue
{
    abstract protected static function assertValue(mixed $value): void;
}

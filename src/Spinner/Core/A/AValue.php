<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Contract\IValue;

abstract class AValue implements IValue
{
    private mixed $value;

    abstract protected static function assertValue(mixed $value): void;

    public function setValue($value): void
    {
        self::assertValue($value);
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}

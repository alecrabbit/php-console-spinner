<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IValue;

abstract class AValue implements IValue
{
    protected $value;

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        static::assertValue($value);
        $this->value = $value;
    }

    abstract protected static function assertValue(mixed $value): void;
}

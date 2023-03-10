<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IFloatValue extends IValue
{
    public function getValue(): float;

    /**
     * @param float $value
     */
    public function setValue($value): void;

    public function getMin(): float;

    public function getMax(): float;

}

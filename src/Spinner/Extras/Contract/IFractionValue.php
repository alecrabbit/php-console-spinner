<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IFractionValue
{
    public function getValue(): float;

    public function getMin(): float;

    public function getMax(): float;

    public function getSteps(): int;

    public function setValue(float $value): void;

    /**
     * @throws InvalidArgumentException
     */
    public function advance(int $steps): void;

    public function finish(): void;

    public function isFinished(): bool;
}

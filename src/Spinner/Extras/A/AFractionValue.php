<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\A;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\IFractionValue;

abstract class AFractionValue implements IFractionValue
{
    protected float $value;
    protected bool $finished = false;
    protected float $stepValue;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        float $startValue = 0.0,
        protected readonly int $steps = 100,
        protected readonly float $min = 0.0,
        protected readonly float $max = 1.0,
        protected readonly bool $autoFinish = false,
    ) {
        self::assert($this);
        $this->stepValue = ($this->max - $this->min) / $this->steps;
        $this->setValue($startValue);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function assert(AFractionValue $value): void
    {
        match (true) {
            $value->min > $value->max =>
            throw new InvalidArgumentException(
                sprintf(
                    'Max value should be greater than min value. Min: "%s", Max: "%s".',
                    $value->min,
                    $value->max,
                )
            ),
            $value->min === $value->max =>
            throw new InvalidArgumentException(
                'Min and Max values cannot be equal.'
            ),
            0 > $value->steps || 0 === $value->steps =>
            throw new InvalidArgumentException(
                sprintf(
                    'Steps should be greater than 0. Steps: "%s".',
                    $value->steps,
                )
            ),
            default => null,
        };
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
        $this->checkBounds();
    }

    public function getMin(): float
    {
        return $this->min;
    }

    public function getMax(): float
    {
        return $this->max;
    }

    /** @inheritdoc */
    public function advance(int $steps = 1): void
    {
        if ($this->finished) {
            return;
        }

        $this->value += $steps * $this->stepValue;
        $this->checkBounds();
        $this->autoFinish();
    }

    protected function checkBounds(): void
    {
        if ($this->value > $this->max) {
            $this->value = $this->max;
        }
        if ($this->value < $this->min) {
            $this->value = $this->min;
        }
    }

    protected function autoFinish(): void
    {
        if ($this->autoFinish && $this->value === $this->max) {
            $this->finish();
        }
    }

    public function finish(): void
    {
        $this->finished = true;
        $this->value = $this->max;
    }

    public function getSteps(): int
    {
        return $this->steps;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }
}

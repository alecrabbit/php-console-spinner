<?php
declare(strict_types=1);
// 11.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class IntegerNormalizerBuilder implements IIntegerNormalizerBuilder
{
    protected ?int $divisor = null;
    protected ?int $min = null;

    public function build(): IIntegerNormalizer
    {
        $this->validate();

        return
            new IntegerNormalizer(
                $this->divisor,
                $this->min,
            );
    }

    protected function validate(): void
    {
        match (true) {
            null === $this->divisor => throw new LogicException('Divisor value is not set.'),
            null === $this->min => throw new LogicException('Min value is not set.'),
            default => null,
        };
    }

    public function withDivisor(int $divisor): IIntegerNormalizerBuilder
    {
        $clone = clone $this;
        $clone->divisor = $divisor;
        return $clone;
    }

    public function withMin(int $min): IIntegerNormalizerBuilder
    {
        $clone = clone $this;
        $clone->min = $min;
        return $clone;
    }
}

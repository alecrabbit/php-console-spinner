<?php

declare(strict_types=1);

// 11.04.23

namespace AlecRabbit\Spinner\Core\Contract;

interface IIntegerNormalizerBuilder
{
    public function build(): IIntegerNormalizer;

    public function withDivisor(int $divisor): IIntegerNormalizerBuilder;

    public function withMin(int $min): IIntegerNormalizerBuilder;
}

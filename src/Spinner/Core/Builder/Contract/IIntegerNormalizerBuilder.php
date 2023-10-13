<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;

interface IIntegerNormalizerBuilder
{
    public function build(): IIntegerNormalizer;

    public function withDivisor(int $divisor): IIntegerNormalizerBuilder;

    public function withMin(int $min): IIntegerNormalizerBuilder;
}

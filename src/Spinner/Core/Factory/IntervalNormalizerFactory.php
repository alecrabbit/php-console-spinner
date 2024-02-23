<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Contract\IDivisorProvider;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\IntervalNormalizer;

final readonly class IntervalNormalizerFactory implements IIntervalNormalizerFactory
{
    public function __construct(
        private IIntegerNormalizerBuilder $integerNormalizerBuilder,
        private IDivisorProvider $divisorProvider,
    ) {
    }

    public function create(NormalizerMode $normalizerMode): IIntervalNormalizer
    {
        $divisor = $this->divisorProvider->getDivisor($normalizerMode);

        $integerNormalizer = $this->integerNormalizerBuilder
            ->withDivisor($divisor)
            ->withMin($divisor)
            ->build()
        ;

        return new IntervalNormalizer($integerNormalizer);
    }
}

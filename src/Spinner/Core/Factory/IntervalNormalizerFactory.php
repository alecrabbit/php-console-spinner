<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\IntervalNormalizer;

final class IntervalNormalizerFactory implements IIntervalNormalizerFactory
{
    public function __construct(
        protected IIntegerNormalizerBuilder $integerNormalizerBuilder,
        protected NormalizerMode $normalizerMode,
    ) {
    }

    public function create(): IIntervalNormalizer
    {
        return new IntervalNormalizer(
            $this->buildIntegerNormalizer(),
        );
    }

    private function buildIntegerNormalizer(): IIntegerNormalizer
    {
        $divisor = $this->getDivisor();

        return $this->integerNormalizerBuilder
            ->withDivisor($divisor)
            ->withMin($divisor)
            ->build()
        ;
    }

    private function getDivisor(): int
    {
        return match ($this->normalizerMode) {
            NormalizerMode::SMOOTH => 40,
            NormalizerMode::BALANCED => 100,
            NormalizerMode::PERFORMANCE => 200,
            NormalizerMode::SLOW => 1000,
            NormalizerMode::STILL => 900000,
        };
    }
}

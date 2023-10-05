<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMethodMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\IntervalNormalizer;

final class IntervalNormalizerFactory implements IIntervalNormalizerFactory
{
    public function __construct(
        protected IIntegerNormalizerBuilder $integerNormalizerBuilder,
        protected NormalizerMethodMode $normalizerMode,
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
        return
            match ($this->normalizerMode) {
                NormalizerMethodMode::SMOOTH => 20,
                NormalizerMethodMode::BALANCED => 50,
                NormalizerMethodMode::PERFORMANCE => 100,
                NormalizerMethodMode::SLOW => 1000,
                NormalizerMethodMode::STILL => 900000,
            };
    }
}

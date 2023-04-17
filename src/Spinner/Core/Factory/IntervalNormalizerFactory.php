<?php

declare(strict_types=1);

// 11.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionNormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizer;
use AlecRabbit\Spinner\Core\Contract\IIntegerNormalizerBuilder;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalNormalizerFactory;
use AlecRabbit\Spinner\Core\IntervalNormalizer;

final class IntervalNormalizerFactory implements IIntervalNormalizerFactory
{
    public function __construct(
        protected IIntegerNormalizerBuilder $integerNormalizerBuilder,
        protected OptionNormalizerMode $normalizerMode,
    ) {
    }

    public function create(): IIntervalNormalizer
    {
        return
            new IntervalNormalizer(
                $this->buildIntegerNormalizer(),
            );
    }

    private function buildIntegerNormalizer(): IIntegerNormalizer
    {
        $divisor = $this->getDivisor();

        return
            $this->integerNormalizerBuilder
                ->withDivisor($divisor)
                ->withMin($divisor)
                ->build()
        ;
    }

    protected function getDivisor(): int
    {
        return
            match ($this->normalizerMode) {
                OptionNormalizerMode::SMOOTH => 20,
                OptionNormalizerMode::BALANCED => 50,
                OptionNormalizerMode::PERFORMANCE => 100,
                OptionNormalizerMode::SLOW => 1000,
                OptionNormalizerMode::STILL => 900000,
            };
    }
}

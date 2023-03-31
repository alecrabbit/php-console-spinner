<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\IntegerNormalizer;

final class IntervalFactory extends AFactory implements IIntervalFactory
{
    protected IDefaultsProvider $defaultsProvider;

    public function __construct(IContainer $container)
    {
        parent::__construct($container);
        $this->defaultsProvider = $this->getDefaultsProvider();
    }

    public function createDefault(): IInterval
    {
        /** @var null|int $normalized */
        static $normalized = null;

        if (null === $normalized) {
//            $defaults = $this->getDefaultsProvider();
//            dump($defaults);
            $normalized = $this->normalize(
                1000, // FIXME <-- hard code: $defaults->?->getInterval()
            );
        }

        return
            new Interval($normalized);
    }

    protected function normalize(int|IInterval $interval): int
    {
        if ($interval instanceof IInterval) {
            $interval = (int)$interval->toMilliseconds();
        }

        return IntegerNormalizer::normalize($interval);
    }

    public function createStill(): IInterval
    {
        return new Interval();
    }

    public function createNormalized(int $interval): IInterval
    {
        return new Interval($this->normalize($interval));
    }
}

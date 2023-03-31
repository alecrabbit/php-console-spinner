<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;
use AlecRabbit\Spinner\Core\Factory\A\AFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;

final class IntervalFactory extends AFactory implements IIntervalFactory
{
    protected IDefaultsProvider $defaultsProvider;
    protected IIntervalNormalizer $intervalNormalizer;

    public function __construct(IContainer $container)
    {
        parent::__construct($container);
        $this->defaultsProvider = $this->getDefaultsProvider();
        $this->intervalNormalizer = $this->getIntervalNormalizer();
    }

    public function createDefault(): IInterval
    {
        /** @var null|IInterval $normalizedDefaultInterval */
        static $normalizedDefaultInterval = null;

        if (null === $normalizedDefaultInterval) {
            $normalizedDefaultInterval =
                $this->intervalNormalizer->normalize(
                    $this->defaultsProvider->getAuxSettings()->getInterval(),
                );
        }

        return
            $normalizedDefaultInterval;
    }

    public function createStill(): IInterval
    {
        return new Interval();
    }

    public function createNormalized(int $interval): IInterval
    {
        return
            $this->intervalNormalizer->normalize(
                new Interval($interval)
            );
    }

}

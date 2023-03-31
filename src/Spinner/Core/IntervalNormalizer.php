<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;


use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\A\AContainerServices;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

final class IntervalNormalizer extends AContainerServices implements IIntervalNormalizer
{
    protected IIntegerNormalizer $normalizer;

    public function __construct(
        IContainer $container,
        protected NormalizerMode $mode = NormalizerMode::BALANCED,
    ) {
        parent::__construct($container);
        $this->normalizer = $this->getIntegerNormalizer();
    }

    protected function getIntegerNormalizer(): IIntegerNormalizer
    {
        return $this->container->get(IIntegerNormalizer::class);
    }

    public function normalize(IInterval $interval): IInterval
    {
        return
            new Interval(
                $this->normalizer->normalize((int)$interval->toMilliseconds())
            );
    }
}

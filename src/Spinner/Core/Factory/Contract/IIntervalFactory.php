<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;
use AlecRabbit\Spinner\Core\Factory\A\AIntervalFactory;
use AlecRabbit\Spinner\Core\Interval;

interface IIntervalFactory
{
    final public const NORMALIZER_MODE = NormalizerMode::BALANCED;

    public static function createDefault(): IInterval;

    public static function createNormalized(int $interval): IInterval;

    public static function overrideNormalizerMode(NormalizerMode $mode): void;
}

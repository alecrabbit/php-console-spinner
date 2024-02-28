<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IIntervalNormalizer;

interface IIntervalNormalizerFactory
{
    public function create(NormalizerMode $normalizerMode): IIntervalNormalizer;
}

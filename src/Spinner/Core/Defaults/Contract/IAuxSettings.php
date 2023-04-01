<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\NormalizerMode;

interface IAuxSettings
{
    public function getInterval(): IInterval;

    public function setInterval(IInterval $interval): IAuxSettings;

    public function getNormalizerMode(): NormalizerMode;

    public function setNormalizerMode(NormalizerMode $normalizerMode): IAuxSettings;
}

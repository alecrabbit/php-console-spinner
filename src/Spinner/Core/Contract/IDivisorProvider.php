<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;

interface IDivisorProvider
{
    public function getDivisor(NormalizerMode $normalizerMode): int;
}

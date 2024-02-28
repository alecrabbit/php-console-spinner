<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Mode\NormalizerMode;
use AlecRabbit\Spinner\Core\Contract\IDivisorProvider;

final readonly class DivisorProvider implements IDivisorProvider
{
    public function getDivisor(NormalizerMode $normalizerMode): int
    {
        return match ($normalizerMode) {
            NormalizerMode::EXTREME => 10,
            NormalizerMode::SMOOTH => 30,
            NormalizerMode::BALANCED => 100,
            NormalizerMode::PERFORMANCE => 200,
            NormalizerMode::SLOW => 1000,
            NormalizerMode::STILL => 900000,
        };
    }
}

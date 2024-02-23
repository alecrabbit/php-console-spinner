<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Mode;

enum NormalizerMode
{
    case EXTREME;
    case SMOOTH;
    case BALANCED;
    case PERFORMANCE;
    case SLOW;
    case STILL;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Option;

enum NormalizerOption
{
    case AUTO;
    case SMOOTH;
    case BALANCED;
    case PERFORMANCE;
    case SLOW;
    case STILL;
}

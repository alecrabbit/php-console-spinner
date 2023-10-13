<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Mode;

enum NormalizerMethodMode
{
    case SMOOTH;
    case BALANCED;
    case PERFORMANCE;
    case SLOW;
    case STILL;
}

<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract\Option;

enum OptionNormalizerMode
{
    case SMOOTH;
    case BALANCED;
    case PERFORMANCE;
    case SLOW;
    case STILL;
}

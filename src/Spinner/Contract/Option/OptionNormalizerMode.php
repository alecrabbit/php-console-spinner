<?php
// 19.03.23
namespace AlecRabbit\Spinner\Contract\Option;

enum OptionNormalizerMode
{
    case SMOOTH;
    case BALANCED;
    case PERFORMANCE;
    case SLOW;
    case STILL;
}

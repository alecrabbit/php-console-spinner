<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Option;

enum StylingMethodOption: int
{
    case AUTO = -1;
    case NONE = 0;
    case ANSI4 = 16;
    case ANSI8 = 256;
    case ANSI24 = 65535;
}

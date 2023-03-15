<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

enum ColorMode
{
    case NONE;
    case ANSI4;
    case ANSI8;
    case ANSI24;
}

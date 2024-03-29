<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Mode;

enum RunMethodMode
{
    case SYNCHRONOUS; // long value name for readability

    case ASYNC;
}

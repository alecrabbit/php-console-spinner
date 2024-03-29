<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Option;

enum RunMethodOption
{
    case AUTO;

    case SYNCHRONOUS; // long value name for readability

    case ASYNC;
}

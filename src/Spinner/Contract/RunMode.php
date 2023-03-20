<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

enum RunMode
{
    case SYNCHRONOUS; // long value name for readability

    case ASYNC;
}

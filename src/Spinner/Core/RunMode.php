<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

enum RunMode
{
    case SYNCHRONOUS; // intentionally long name for readability

    case ASYNC;
}

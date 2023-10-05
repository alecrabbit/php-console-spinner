<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop\Creator;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;

final class RevoltLoopCreator implements ILoopCreator
{
    public static function create(): ILoop
    {
        return
            new RevoltLoopAdapter();
    }
}

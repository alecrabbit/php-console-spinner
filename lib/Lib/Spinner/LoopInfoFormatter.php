<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\ILoopInfoFormatter;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

final readonly class LoopInfoFormatter implements ILoopInfoFormatter
{
    public function format(?ILoop $loop): string
    {
        return $loop instanceof ILoop
            ? sprintf('Using loop: "%s".', $loop::class)
            : 'No loop available.';
    }
}

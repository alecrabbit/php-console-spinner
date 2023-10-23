<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

interface IConsoleCursorBuilder
{
    public function build(): IConsoleCursor;

    public function withOutput(IBufferedOutput $output): IConsoleCursorBuilder;

    public function withCursorVisibilityMode(CursorVisibilityMode $cursorVisibilityMode): IConsoleCursorBuilder;
}

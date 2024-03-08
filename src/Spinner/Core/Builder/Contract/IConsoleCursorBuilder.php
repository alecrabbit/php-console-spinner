<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

interface IConsoleCursorBuilder
{
    public function build(): IConsoleCursor;

    public function withCursorMode(CursorMode $cursorVisibilityMode): IConsoleCursorBuilder;

    public function withBuffer(IBuffer $buffer): IConsoleCursorBuilder;
}

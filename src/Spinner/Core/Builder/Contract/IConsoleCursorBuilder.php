<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\Option\CursorVisibilityOption;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

interface IConsoleCursorBuilder
{
    public function build(): IConsoleCursor;

    public function withOutput(IOutput $output): IConsoleCursorBuilder;

    public function withOptionCursor(CursorVisibilityOption $getCursorOption): IConsoleCursorBuilder;
}

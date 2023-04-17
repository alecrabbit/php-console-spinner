<?php

declare(strict_types=1);

// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

interface IConsoleCursorBuilder
{
    public function build(): IConsoleCursor;

    public function withOutput(IOutput $output): IConsoleCursorBuilder;

    public function withOptionCursor(OptionCursor $getCursorOption): IConsoleCursorBuilder;
}

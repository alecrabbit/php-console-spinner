<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

interface ICursorBuilder
{
    public function build(): ICursor;

    public function withOutput(IOutput $output): ICursorBuilder;

    public function withCursorOption(OptionCursor $getCursorOption): ICursorBuilder;
}

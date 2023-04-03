<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\OptionCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;

interface ICursorBuilder
{
    public function build(): ICursor;

    public function withOutput(IOutput $output): ICursorBuilder;

    public function withCursorOption(OptionCursor $getCursorOption): ICursorBuilder;
}
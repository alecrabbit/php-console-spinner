<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Revolver\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

use AlecRabbit\Spinner\Core\WidthDeterminer;

use const AlecRabbit\Spinner\CSI;
use const AlecRabbit\Spinner\RESET;

final class FramesRenderer extends AFramesRenderer
{
    protected function createFrame(mixed $entry): IFrame
    {
        return new Frame($entry, WidthDeterminer::determine($entry));
    }
}
<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use AlecRabbit\Spinner\I\IFrame;

interface IDriver
{
    public function erase(IFrame $frame): void;

    public function display(IFrame $frame, int $widthDiff = 0): void;

    public function hideCursor(): void;

    public function showCursor(): void;

    public function interrupt(?string $interruptMessage = null): void;

    public function finalize(?string $finalMessage = null): void;
}

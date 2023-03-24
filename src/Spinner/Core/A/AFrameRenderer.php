<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\WidthDeterminer;

abstract class AFrameRenderer implements IFrameRenderer
{
    public function render(string $entry): IFrame
    {
        return FrameFactory::create($entry, WidthDeterminer::determine($entry));
    }

    public function isStyleEnabled(): bool
    {
        return false;
    }
}
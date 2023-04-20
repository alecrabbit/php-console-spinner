<?php

declare(strict_types=1);

// 24.03.23

namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;

final class CharFrameRenderer extends AFrameRenderer implements ICharFrameRenderer
{
    public function render(string $entry): IFrame
    {
        return $this->frameFactory->create($entry);
    }

    public function emptyFrame(): IFrame
    {
        return $this->frameFactory->createEmpty();
    }
}

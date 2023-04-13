<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;

final class CharFrameCollectionRenderer extends AFrameCollectionRenderer implements ICharFrameCollectionRenderer
{
    public function __construct(
        protected ICharFrameRenderer $frameRenderer,
    ) {
    }

    protected function createFrame(string|IStyle $entry): IFrame
    {
        return $this->frameRenderer->render($entry);
    }
}

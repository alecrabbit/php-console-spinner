<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\AFrameRenderer;
use AlecRabbit\Spinner\Extras\Contract\ICharFrameRenderer;

final class CharFrameRenderer extends AFrameRenderer implements ICharFrameRenderer
{
    public function render(string $entry): IFrame
    {
        return $this->frameFactory->create($entry);
    }
}

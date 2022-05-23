<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;

final class Renderer implements Contract\IRenderer
{
    public function __construct(
        private Color $color,
        private FrameHolder $frameHolder,
    ) {
    }

    public function renderFrame(IWigglerContainer $wigglers, null|float|int $interval = null): IFrame
    {
        $fg = $this->color->next();
        $char = $this->frameHolder->next();

        return
            new Frame(
                "38;5;{$fg}m{$char}",
                1
            );
    }
}

<?php

declare(strict_types=1);
// 13.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Render\StyleFrameRenderer;

final class StyleFrameRendererFactory implements IStyleFrameRendererFactory
{
    public function __construct(
        protected IFrameFactory $frameFactory,
        protected IStyleRenderer $styleRenderer,
        protected OptionStyleMode $styleMode,
    ) {
    }

    public function create(OptionStyleMode $mode): IStyleFrameRenderer
    {
        return
            new StyleFrameRenderer(
                frameFactory: $this->frameFactory,
                styleRenderer: $this->styleRenderer,
                styleMode: $this->styleMode->lowest($mode),
            );
    }
}

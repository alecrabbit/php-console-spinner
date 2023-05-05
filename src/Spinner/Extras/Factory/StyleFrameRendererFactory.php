<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleRendererFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\StyleFrameRenderer;

final class StyleFrameRendererFactory implements IStyleFrameRendererFactory
{
    public function __construct(
        protected IStyleFrameFactory $frameFactory,
        protected IStyleRendererFactory $styleRendererFactory,
        protected OptionStyleMode $styleMode,
    ) {
    }

    public function create(OptionStyleMode $mode): IStyleFrameRenderer
    {
        $styleMode = $this->styleMode->lowest($mode);
        return
            new StyleFrameRenderer(
                frameFactory: $this->frameFactory,
                styleRenderer: $this->styleRendererFactory->create($styleMode),
                styleMode: $styleMode,
            );
    }
}

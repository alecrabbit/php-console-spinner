<?php

declare(strict_types=1);
// 24.03.23
namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleRenderer;

final class StyleFrameRenderer implements IStyleFrameRenderer
{

    public function __construct(
        protected IFrameFactory $frameFactory,
        protected IStyleRenderer $styleRenderer,
        protected OptionStyleMode $styleMode,
    ) {
    }

    public function render(IStyle $style): IFrame
    {
        if ($this->styleMode === OptionStyleMode::NONE) {
            return $this->frameFactory->create('%s', 0);
        }
        return $this->createFrameFromStyle($style, $this->styleMode);
    }

    protected function createFrameFromStyle(IStyle $style, OptionStyleMode $mode): IFrame
    {
        if ($style->isEmpty()) {
            return $this->frameFactory->create($style->getFormat(), $style->getWidth());
        }

        return
            $this->frameFactory->create(
                $this->styleRenderer->render($style, $mode),
                $style->getWidth()
            );
    }

    /** @inheritdoc  */
    public function emptyFrame(): IFrame
    {
        return $this->frameFactory->create('%s', 0);
    }
}

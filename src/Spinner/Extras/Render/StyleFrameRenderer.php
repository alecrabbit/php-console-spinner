<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleRenderer;

final class StyleFrameRenderer implements IStyleFrameRenderer
{
    public function __construct(
        protected IStyleFrameFactory $frameFactory,
        protected IStyleRenderer $styleRenderer,
        protected OptionStyleMode $styleMode,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyle $style): IFrame
    {
        if ($this->styleMode === OptionStyleMode::NONE) {
            return $this->frameFactory->create('%s', 0);
        }
        return $this->createFrameFromStyle($style);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function createFrameFromStyle(IStyle $style): IFrame
    {
        if ($style->isEmpty()) {
            return $this->frameFactory->create($style->getFormat(), $style->getWidth());
        }

        return $this->frameFactory->create(
            $this->styleRenderer->render($style),
            $style->getWidth()
        );
    }
}

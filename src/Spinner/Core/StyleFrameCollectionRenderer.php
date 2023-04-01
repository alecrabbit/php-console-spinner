<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\A\AFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;

final class StyleFrameCollectionRenderer extends AFrameCollectionRenderer implements IStyleFrameCollectionRenderer
{
    private OptionStyleMode $styleMode = OptionStyleMode::NONE;

    public function __construct(
        protected IStyleFrameRenderer $frameRenderer,
        protected IFrameFactory $frameFactory,
    ) {
    }

    /** @inheritdoc */
    public function pattern(IPattern $pattern): IFrameCollectionRenderer
    {
        if (!$pattern instanceof IStylePattern) {
            throw new InvalidArgumentException(
                sprintf(
                    'Pattern should be instance of "%s", "%s" given.',
                    IStylePattern::class,
                    get_debug_type($pattern)
                )
            );
        }

        $clone = clone $this;
        $clone->pattern = $pattern;
        $clone->styleMode = $pattern->getStyleMode();
        return $clone;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function createFrame(string|IStyle $entry): IFrame
    {
        return $this->frameRenderer->render($entry, $this->styleMode);
    }

    /** @inheritdoc */
    public function render(): IFrameCollection
    {
        if ($this->frameRenderer->isStylingDisabled()) {
            return
                $this->createCollectionWithOneStyle();
        }
        return parent::render();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function createCollectionWithOneStyle(): FrameCollection
    {
        return
            $this->createCollection(
                new ArrayObject(
                    [
                        $this->frameFactory->create('%s', 0), // no styling
                    ]
                )
            );
    }
}

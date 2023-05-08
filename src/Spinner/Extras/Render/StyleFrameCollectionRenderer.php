<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\IStyleFrameRenderer;
use Stringable;
use Traversable;

final class StyleFrameCollectionRenderer implements IStyleFrameCollectionRenderer
{
    private IStyleFrameRenderer $styleFrameRenderer;

    public function __construct(
        protected IStyleFrameRendererFactory $styleFrameRendererFactory,
        protected IStyleFactory $styleFactory,
    ) {
    }

    public function render(IStylePattern $pattern): IFrameCollection
    {
        if (OptionStyleMode::NONE === $pattern->getStyleMode()) {
            return new FrameCollection($this->generateFrames($pattern));
        }
        $this->styleFrameRenderer = // TODO (2023-04-20 13:50) [Alec Rabbit]: can be retrieved from the container?
            $this->styleFrameRendererFactory->create(
                $pattern->getStyleMode()
            );

        return new FrameCollection($this->generateFrames($pattern));
    }

    /**
     * @throws InvalidArgumentException
     */
    private function generateFrames(IStylePattern $pattern): Traversable
    {
        /** @var IFrame|Stringable|string|IStyle $entry */
        foreach ($pattern->getEntries() as $entry) {
            if ($entry instanceof IFrame) {
                yield $entry;
                continue;
            }

            if ($entry instanceof Stringable) {
                $entry = (string)$entry;
            }

            yield $this->createFrame($entry);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private function createFrame(string|IStyle $style): IFrame
    {
        if (is_string($style)) {
            $style = $this->styleFactory->fromString($style);
        }
        return $this->styleFrameRenderer->render($style);
    }
}

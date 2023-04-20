<?php

declare(strict_types=1);

// 10.03.23

namespace AlecRabbit\Spinner\Core\Render;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRendererFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\NoStylePattern;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Stringable;
use Traversable;

final class StyleFrameCollectionRenderer implements IStyleFrameCollectionRenderer
{
    private IStyleFrameRenderer $styleFrameRenderer;

    public function __construct(
        protected IStyleFrameRendererFactory $styleFrameRendererFactory,
        protected IStyleFactory $styleFactory,
        protected OptionStyleMode $styleMode,
    ) {
    }

    public function render(IStyleLegacyPattern $pattern): IFrameCollection
    {
        if (OptionStyleMode::NONE === $this->styleMode) {
            // FIXME (2023-04-20 13:47) [Alec Rabbit]: stub!
            return new FrameCollection($this->generateFrames(new NoStylePattern()));
        }
        dump($pattern);
        $this->styleFrameRenderer = // TODO (2023-04-20 13:50) [Alec Rabbit]: can be retrieved from the container?
            $this->styleFrameRendererFactory->create(
                dump($pattern->getStyleMode())
            );

        return new FrameCollection($this->generateFrames($pattern));
    }

    /**
     * @throws InvalidArgumentException
     */
    private function generateFrames(IStyleLegacyPattern $pattern): Traversable
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

<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameRenderer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Stringable;
use Traversable;

final class StyleFrameCollectionRenderer implements IStyleFrameCollectionRenderer
{
    public function __construct(
        protected IStyleFrameRenderer $styleFrameRenderer,
        protected IStyleFactory $styleFactory,
    ) {
    }

    /** @inheritdoc */
    public function render(IStylePattern $pattern): IFrameCollection
    {
        return
            new FrameCollection($this->generateFrames($pattern));
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function generateFrames(IStylePattern $pattern): Traversable
    {
        $this->styleFrameRenderer->useLowestStyleMode($pattern->getStyleMode());

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
    protected function createFrame(string|IStyle $entry): IFrame
    {
        if (is_string($entry)) {
            $entry = $this->styleFactory->fromString($entry);
        }
        return $this->styleFrameRenderer->render($entry);
    }
}

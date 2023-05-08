<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Render;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Extras\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Extras\Render\Contract\ICharFrameCollectionRenderer;
use Stringable;
use Traversable;

final class CharFrameCollectionRenderer implements ICharFrameCollectionRenderer
{
    public function __construct(
        protected ICharFrameRenderer $frameRenderer,
    ) {
    }

    public function render(IPattern $pattern): IFrameCollection
    {
        return new FrameCollection($this->generateFrames($pattern));
    }

    private function generateFrames(IPattern $pattern): Traversable
    {
        /** @var IFrame|Stringable|string $entry */
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

    private function createFrame(string $entry): IFrame
    {
        return $this->frameRenderer->render($entry);
    }
}

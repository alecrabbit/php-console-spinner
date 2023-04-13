<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Contract\ICharFrameRenderer;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Stringable;
use Traversable;

final class CharFrameCollectionRenderer implements ICharFrameCollectionRenderer
{
    public function __construct(
        protected ICharFrameRenderer $frameRenderer,
    ) {
    }

    /** @inheritdoc */
    public function render(IPattern $pattern): IFrameCollection
    {
        return
            new FrameCollection($this->generateFrames($pattern));
    }

    protected function generateFrames(IPattern $pattern): Traversable
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

    protected function createFrame(string|IStyle $entry): IFrame
    {
        $this->assertEntry($entry);
        return $this->frameRenderer->render($entry);
    }

    protected function assertEntry(IStyle|string $entry): void
    {
        if ($entry instanceof IStyle) {
            throw new InvalidArgumentException('Style is not allowed here.');
        }
    }
}

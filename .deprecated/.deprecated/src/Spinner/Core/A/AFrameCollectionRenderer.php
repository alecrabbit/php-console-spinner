<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Contract\IFrameRenderer;
use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Contract\IStyle;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Generator;
use Stringable;
use Traversable;

abstract class AFrameCollectionRenderer implements IFrameCollectionRenderer
{
    protected ?IPattern $pattern = null;

    /** @inheritdoc */
    public function pattern(IPattern $pattern): IFrameCollectionRenderer
    {
        $clone = clone $this;
        $clone->pattern = $pattern;
        return $clone;
    }

    /** @inheritdoc */
    public function render(): IFrameCollection
    {
        $cb =
            /**
             * @return Generator<IFrame>
             * @throws InvalidArgumentException
             */
            function (): Generator {
                if (null === $this->pattern) {
                    throw new InvalidArgumentException('Pattern is not set.');
                }
                /** @var IFrame|Stringable|string|IStyle $entry */
                foreach ($this->pattern->getPattern() as $entry) {
                    if ($entry instanceof IFrame) {
                        yield $entry;
                        continue;
                    }

                    if ($entry instanceof Stringable) {
                        $entry = (string)$entry;
                    }

                    yield $this->createFrame($entry);
                }
            };

        return
            $this->createCollection($cb());
    }

    /**
     * @throws InvalidArgumentException
     */
    abstract protected function createFrame(string|IStyle $entry): IFrame;

    /**
     * @throws InvalidArgumentException
     */
    protected function createCollection(Traversable $frames): FrameCollection
    {
        return new FrameCollection($frames);
    }
}
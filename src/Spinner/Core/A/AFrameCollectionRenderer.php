<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Generator;
use Stringable;
use Traversable;

abstract class AFrameCollectionRenderer implements IFrameCollectionRenderer
{
    protected ?IPattern $pattern = null;

    /** @inheritdoc */
    public function render(IPattern $pattern): IFrameCollection
    {
        $cb =
            /**
             * @param IPattern $pattern
             * @return Generator<IFrame>
             * @throws InvalidArgumentException
             */
            function (IPattern $pattern): Generator {
                /** @var IFrame|Stringable|string|IStyle $entry */
                foreach ($pattern->getPattern() as $entry) {
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
            $this->createCollection($cb($pattern));
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

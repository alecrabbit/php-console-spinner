<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameCollection;
use AlecRabbit\Spinner\Contract\IFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Generator;
use Stringable;

abstract class AFrameCollectionRenderer extends ADefaultsAwareClass implements IFrameCollectionRenderer
{
    public function __construct(
        protected IPattern $pattern
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function render(): IFrameCollection
    {
        $cb =
            /**
             * @return Generator<IFrame>
             * @throws InvalidArgumentException
             */
            function (): Generator {
                /** @var IFrame|Stringable|string|int|array<string,int|null> $entry */
                foreach ($this->pattern->getPattern() as $entry) {
                    if ($entry instanceof IFrame) {
                        yield $entry;
                        continue;
                    }
                    yield $this->create($entry);
                }
            };

        return
            new FrameCollection($cb());
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function create(Stringable|string|int|array $entry): IFrame
    {
        if ($entry instanceof Stringable) {
            $entry = (string)$entry;
        }

        if (is_string($entry) || is_int($entry)) {
            return
                $this->createFrame($entry);
        }

        return $this->createFromArray($entry);
    }

    /**
     * @throws InvalidArgumentException
     */
    abstract protected function createFrame(int|string $entry): IFrame;

    /**
     * @throws InvalidArgumentException
     */
    abstract protected function createFromArray(array $entry): IFrame;
}

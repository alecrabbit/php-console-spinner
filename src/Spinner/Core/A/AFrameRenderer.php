<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IFrameRenderer;
use AlecRabbit\Spinner\Core\Factory\A\ADefaultsAwareClass;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

abstract class AFrameRenderer extends ADefaultsAwareClass implements IFrameRenderer
{
    public function __construct(
        protected IPattern $pattern
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function render(): iterable
    {
        $frames = [];
        /** @var IFrame|string|array<string,int|null> $entry */
        foreach ($this->pattern->getPattern() as $entry) {
            if ($entry instanceof IFrame) {
                $frames[] = $entry;
                continue;
            }
            $frames[] = $this->createFrame($entry);
        }
        return
            $frames;
    }

    /**
     * @throws InvalidArgumentException
     */
    abstract protected function createFrame(mixed $entry): IFrame;
}

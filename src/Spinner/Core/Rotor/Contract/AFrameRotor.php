<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\WidthDefiner;

abstract class AFrameRotor extends ARotor implements IFrameRotor
{
    private int $leadingSpacerWidth;
    private int $trailingSpacerWidth;

    public function __construct(
        IFrameCollection $frames,
        protected readonly string $leadingSpacer = C::EMPTY_STRING,
        protected readonly string $trailingSpacer = C::EMPTY_STRING,
    ) {
        parent::__construct($frames->toArray(), $frames->getInterval());
        $this->leadingSpacerWidth = WidthDefiner::define($this->leadingSpacer);
        $this->trailingSpacerWidth = WidthDefiner::define($this->trailingSpacer);
    }

    public function getWidth(): int
    {
        return $this->leadingSpacerWidth + $this->getCurrentFrame()->sequenceWidth + $this->trailingSpacerWidth;
    }

    private function getCurrentFrame(): IFrame
    {
        return $this->data[$this->currentIndex];
    }

    protected function current(?IInterval $interval = null): string
    {
        return
            $this->addSpacers(
                parent::current($interval)
            );
    }

    protected function addSpacers(string $chars): string
    {
        return $this->leadingSpacer . $chars . $this->trailingSpacer;
    }

}

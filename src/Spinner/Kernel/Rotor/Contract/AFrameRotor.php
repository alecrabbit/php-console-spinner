<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

use AlecRabbit\Spinner\Core\Contract\C;
use AlecRabbit\Spinner\Core\Frame\Contract\ICharFrame;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\WidthDefiner;

abstract class AFrameRotor extends ARotor implements IFrameRotor
{
    private int $leadingSpacerWidth;
    private int $trailingSpacerWidth;

    public function __construct(
        IWFrameCollection $frames,
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

    private function getCurrentFrame(): ICharFrame
    {
        return $this->data[$this->currentIndex];
    }

    protected function render(): string
    {
        return
            $this->addSpacers(
                parent::render()
            );
    }

    protected function addSpacers(string $chars): string
    {
        return $this->leadingSpacer . $chars . $this->trailingSpacer;
    }

}

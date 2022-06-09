<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\IFrameContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\WidthQualifier;

abstract class AFrameRotor extends ARotor implements IStringRotor
{
    private int $leadingSpacerWidth;
    private int $trailingSpacerWidth;

    public function __construct(
        protected readonly IFrameContainer $frames,
        protected readonly string $leadingSpacer = C::EMPTY_STRING,
        protected readonly string $trailingSpacer = C::EMPTY_STRING,
    ) {
        parent::__construct($frames->toArray());
        $this->leadingSpacerWidth = WidthQualifier::qualify($this->leadingSpacer);
        $this->trailingSpacerWidth = WidthQualifier::qualify($this->trailingSpacer);
    }

    public function getWidth(): int
    {
        return $this->leadingSpacerWidth + $this->data[$this->currentIndex]->getWidth() + $this->trailingSpacerWidth;
    }

    protected function nextElement(?IInterval $interval = null): string
    {
        return
            $this->addSpacers(
                parent::nextElement($interval)
            );
    }

    protected function addSpacers(string $chars): string
    {
        return $this->leadingSpacer . $chars . $this->trailingSpacer;
    }

}

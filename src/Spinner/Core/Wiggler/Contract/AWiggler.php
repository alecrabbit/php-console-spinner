<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\ICharsRotor;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Frame;

abstract class AWiggler implements IWiggler
{
    public function __construct(
        protected readonly IStyleRotor $styleRotor,
        protected readonly ICharsRotor $charRotor,
        protected readonly string $leadingSpacer = '',
        protected readonly string $trailingSpacer = '',
    ) {
    }

    public function createFrame(float|int|null $interval = null): IFrame
    {
        return
            new Frame(
                $this->getSequence($interval),
                $this->charRotor->getWidth(),
            );
    }

    protected function getSequence(float|int|null $interval = null): string
    {
        return
            $this->styleRotor->join(
                chars: $this->charRotor->next($interval),
                interval: $interval,
            );
    }
}

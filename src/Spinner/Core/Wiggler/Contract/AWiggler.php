<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\ICharRotor;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Frame;

abstract class AWiggler implements IWiggler
{
    public function __construct(
        protected readonly IStyleRotor $styleRotor,
        protected readonly ICharRotor $charRotor,
        protected readonly string $leadingSpacer = '',
        protected readonly string $trailingSpacer = '',
    ) {
    }

    public function getFrame(float|int|null $interval = null): IFrame
    {
        return
            new Frame(
                $this->getSequence($interval),
                $this->charRotor->getWidth(),
            );
    }

    abstract protected function getSequence(float|int|null $interval = null): string;
}

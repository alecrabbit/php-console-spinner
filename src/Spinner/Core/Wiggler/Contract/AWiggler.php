<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\ICharsRotor;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Frame;

abstract class AWiggler implements IWiggler
{
    protected function __construct(
        protected readonly IStyleRotor $styleRotor,
        protected readonly ICharsRotor $charRotor,
    ) {
    }

    public static function create(
        IStyleRotor $styleRotor,
        ICharsRotor $charRotor,
    ): IWiggler {
        return new static($styleRotor, $charRotor);
    }

    public function createFrame(float|int|null $interval = null): IFrame
    {
        return
            new Frame(
                $this->createSequence($interval),
                $this->charRotor->getWidth(),
            );
    }

    protected function createSequence(float|int|null $interval = null): string
    {
        return
            $this->styleRotor->join(
                chars: $this->charRotor->next($interval),
                interval: $interval,
            );
    }
}

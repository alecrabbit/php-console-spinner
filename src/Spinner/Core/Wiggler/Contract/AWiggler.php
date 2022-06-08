<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStringRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;

abstract class AWiggler implements IWiggler
{
    protected function __construct(
        protected readonly IStyleRotor $styleRotor,
        protected readonly IStringRotor $charRotor,
    ) {
    }

    public static function create(
        IStyleRotor $styleRotor,
        IStringRotor $charRotor,
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

    abstract protected static function assertWiggler(IWiggler|string|float|null $wiggler): void;
}

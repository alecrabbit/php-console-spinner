<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStringRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;

abstract class AWiggler implements IWiggler
{
    protected function __construct(
        protected readonly IStyleRotor $style,
        protected readonly IRotor $rotor,
    ) {
    }

    public static function create(
        IStyleRotor $styleRotor,
        IRotor $charRotor,
    ): IWiggler {
        return new static($styleRotor, $charRotor);
    }

    public function createFrame(?IInterval $interval = null): IFrame
    {
        return
            new Frame(
                $this->createSequence($interval),
                $this->rotor->getWidth(),
            );
    }

    protected function createSequence(?IInterval $interval = null): string
    {
        return
            $this->style->join(
                chars: $this->rotor->next($interval),
                interval: $interval,
            );
    }

    abstract protected static function assertWiggler(IWiggler|string|null $wiggler): void;
}

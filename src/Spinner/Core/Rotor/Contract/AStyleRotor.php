<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor\Contract;

use AlecRabbit\Spinner\Core\Contract\IStyleCollection;
use AlecRabbit\Spinner\Core\Sequencer;

abstract class AStyleRotor extends ARotor implements IStyleRotor
{
    public function __construct(
        IStyleCollection $styles,
    ) {
        parent::__construct($styles->toArray(), $styles->getInterval());
    }

    public function join(string $chars, ?IInterval $interval = null): string
    {
        return
            Sequencer::colorSequence(
                sprintf(
                    '%s%s',
                    $this->next($interval),
                    $chars,
                )
            );
    }

}

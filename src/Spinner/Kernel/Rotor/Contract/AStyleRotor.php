<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

use AlecRabbit\Spinner\Kernel\Contract\IWStyleCollection;

abstract class AStyleRotor extends ARotor implements IStyleRotor
{
    public function __construct(
        IWStyleCollection $styles,
    ) {
        parent::__construct($styles->toArray(), $styles->getInterval());
    }

    public function join(string $chars): string
    {
        return
            sprintf(
                $this->next(),
                $chars,
            );
    }

}

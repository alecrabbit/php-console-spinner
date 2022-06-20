<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor;

use AlecRabbit\Spinner\Kernel\Rotor\Contract\AStyleRotor;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Kernel\StyleCollection;

final class NoStyleRotor extends AStyleRotor
{
    public function __construct()
    {
        parent::__construct(StyleCollection::create());
    }

    public function join(string $chars): string
    {
        return $chars; // no styling
    }
}

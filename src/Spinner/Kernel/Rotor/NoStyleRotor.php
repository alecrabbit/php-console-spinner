<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Rotor;

use AlecRabbit\Spinner\Kernel\Rotor\Contract\AStyleRotor;
use AlecRabbit\Spinner\Kernel\WStyleCollection;

final class NoStyleRotor extends AStyleRotor
{
    public function __construct()
    {
        parent::__construct(WStyleCollection::create());
    }

    public function join(string $chars): string
    {
        return $chars; // no styling
    }
}

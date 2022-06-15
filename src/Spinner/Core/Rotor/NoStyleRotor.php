<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Rotor;

use AlecRabbit\Spinner\Core\Rotor\Contract\AStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\StyleCollection;

final class NoStyleRotor extends AStyleRotor
{
    public function __construct()
    {
        parent::__construct(StyleCollection::create());
    }

    public function join(string $chars, ?IInterval $interval = null): string
    {
        return $chars; // no styling
    }
}

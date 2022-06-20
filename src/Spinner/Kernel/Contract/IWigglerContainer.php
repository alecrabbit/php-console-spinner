<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Kernel\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;
use IteratorAggregate;
use Traversable;

interface IWigglerContainer extends IteratorAggregate,
                                    Renderable,
                                    HasInterval
{
    public function addWiggler(IWiggler $wiggler): IWigglerContainer;

    public function spinner(string|IRevolveWiggler|null $wiggler): void;

    public function progress(float|string|IProgressWiggler|null $wiggler): void;

    public function message(string|IMessageWiggler|null $wiggler): void;
}

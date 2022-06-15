<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use IteratorAggregate;
use Traversable;

interface IWigglerContainer extends IteratorAggregate
{
    public function render(): IFrame;

    public function getIterator(): Traversable;

    public function addWiggler(IWiggler $wiggler): void;

    public function getInterval(): IInterval;

    public function spinner(string|IRevolveWiggler|null $wiggler): void;

    public function progress(float|string|IProgressWiggler|null $wiggler): void;

    public function message(string|IMessageWiggler|null $wiggler): void;
}

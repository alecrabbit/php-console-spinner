<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface IWiggler
{
    public function render(): IFrame;

    /**
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler;

    public function getInterval(): ?IInterval;
}

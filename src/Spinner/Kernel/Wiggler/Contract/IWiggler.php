<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler\Contract;

use AlecRabbit\Spinner\Kernel\Contract\Renderable;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;

interface IWiggler extends Renderable
{
    /**
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler;

    public function getInterval(?IWInterval $preferredInterval = null): ?IWInterval;
}

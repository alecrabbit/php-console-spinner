<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler\Contract;

use AlecRabbit\Spinner\Kernel\Contract\WRenderable;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;

interface IWiggler extends WRenderable
{
    /**
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler;

    public function getInterval(?IWInterval $preferredInterval = null): ?IWInterval;
}

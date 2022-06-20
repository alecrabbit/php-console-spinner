<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler\Contract;

use AlecRabbit\Spinner\Kernel\Contract\Renderable;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;

interface IWiggler extends Renderable
{
    /**
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler;

    public function getInterval(?WIInterval $preferredInterval = null): ?WIInterval;
}

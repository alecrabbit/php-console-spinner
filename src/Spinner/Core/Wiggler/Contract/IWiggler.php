<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\Renderable;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface IWiggler extends Renderable
{
    /**
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler;

    public function getInterval(?IInterval $preferredInterval = null): ?IInterval;
}

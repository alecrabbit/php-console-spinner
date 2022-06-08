<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;

interface IWiggler
{
    public function createFrame(float|int|null $interval = null): IFrame;

    public function update(IWiggler|string|null $wiggler): IWiggler;
}

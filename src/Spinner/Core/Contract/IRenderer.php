<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface IRenderer
{
    public function renderFrame(IWigglerContainer $wigglers, ?IInterval $interval = null): IFrame;
}

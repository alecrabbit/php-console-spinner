<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IRenderer
{
    public function renderFrame(IWigglerContainer $container, null|float|int $interval = null): IFrame;
}

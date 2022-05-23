<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IRenderer
{
    public function renderFrame(null|float|int $interval = null): IFrame;
}

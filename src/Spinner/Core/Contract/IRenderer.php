<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IRenderer
{
    public function createFrame(null|float|int $interval = null): IFrame;
}

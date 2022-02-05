<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Frame;

interface IRenderer
{
    public function createFrame(float|int $interval): Frame;
}

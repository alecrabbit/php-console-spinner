<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IFrame;

interface IStyleFrameFactory
{
    public function create(string $sequence, ?int $width = null): IFrame;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IFrame;

interface IFrameFactory
{

    public function create(string $sequence, ?int $width = null): IFrame;
}

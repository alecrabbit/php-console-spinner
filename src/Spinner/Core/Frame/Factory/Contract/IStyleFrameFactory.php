<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Frame\Factory\Contract;

use AlecRabbit\Spinner\Core\Frame\Contract\IStyleFrame;

interface IStyleFrameFactory
{
    public function create(): IStyleFrame;
}

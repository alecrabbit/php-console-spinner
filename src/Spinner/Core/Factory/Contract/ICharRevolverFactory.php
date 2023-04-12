<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface ICharRevolverFactory
{
    public function createCharRevolver(): IFrameRevolver;
}

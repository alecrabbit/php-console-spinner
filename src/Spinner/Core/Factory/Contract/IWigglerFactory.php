<?php

declare(strict_types=1);
// 15.06.22
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

interface IWigglerFactory
{
    public function createRevolveWiggler(?IFrameCollection $frames = null): IWiggler;
}

<?php

declare(strict_types=1);
// 15.06.22
namespace AlecRabbit\Spinner\Kernel\Factory\Contract;

use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;

interface IWigglerFactory
{
    public function createRevolveWiggler(): IWiggler;
    public function createWiggler(): IWiggler;
}

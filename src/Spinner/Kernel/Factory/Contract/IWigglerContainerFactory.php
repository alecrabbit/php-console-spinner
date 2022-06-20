<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Kernel\Factory\Contract;

use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\WIStyleProvider;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;

interface IWigglerContainerFactory
{
    public function __construct(
        WIStyleProvider $styleRenderer,
        ?IWigglerFactory $wigglerFactory = null,
        ?IWFrameCollection $frames = null,
        ?IWInterval $interval = null,
    );

    public function createContainer(): IWigglerContainer;
}

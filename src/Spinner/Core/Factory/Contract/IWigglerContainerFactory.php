<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleProvider;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface IWigglerContainerFactory
{
    public function __construct(
        IStyleProvider $styleRenderer,
        ?IWigglerFactory $wigglerFactory = null,
        ?IFrameCollection $frames = null,
        ?IInterval $interval = null,
    );

    public function createContainer(): IWigglerContainer;
}

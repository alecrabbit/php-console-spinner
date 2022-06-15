<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

use const AlecRabbit\Cli\TERM_NOCOLOR;

interface IWigglerContainerFactory
{
    public function __construct(
        ?IWigglerFactory $wigglerFactory = null,
        ?IFrameCollection $frames = null,
        int $terminalColorSupport = TERM_NOCOLOR,
        ?IInterval $interval = null,
    );

    public function createContainer(): IWigglerContainer;
}

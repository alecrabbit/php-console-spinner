<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Kernel\Factory;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Kernel\Contract\WIStyleProvider;
use AlecRabbit\Spinner\Kernel\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Kernel\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IWInterval;
use AlecRabbit\Spinner\Kernel\WigglerContainer;

final class WigglerContainerFactory implements IWigglerContainerFactory
{
    private IWigglerFactory $wigglerFactory;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        WIStyleProvider $styleRenderer,
        ?IWigglerFactory $wigglerFactory = null,
        ?IWFrameCollection $frames = null,
        private readonly ?IWInterval $interval = null,
    ) {
        $this->wigglerFactory =
            $wigglerFactory ?? new WigglerFactory(
                $styleRenderer,
                $frames,
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createContainer(): IWigglerContainer
    {
        $container = new WigglerContainer($this->interval);
        return
            $container
                ->addWiggler($this->wigglerFactory->createRevolveWiggler())
                ->addWiggler($this->wigglerFactory->createMessageWiggler())
                ->addWiggler($this->wigglerFactory->createProgressWiggler())
        ;
    }
}

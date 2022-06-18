<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\WigglerContainer;

final class WigglerContainerFactory implements IWigglerContainerFactory
{
    private IWigglerFactory $wigglerFactory;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        IStyleRenderer $styleRenderer,
        ?IWigglerFactory $wigglerFactory = null,
        ?IFrameCollection $frames = null,
        private readonly ?IInterval $interval = null,
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

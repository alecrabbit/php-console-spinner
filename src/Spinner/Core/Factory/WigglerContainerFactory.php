<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStylePatternExtractor;
use AlecRabbit\Spinner\Core\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Core\StyleRenderer;
use AlecRabbit\Spinner\Core\WigglerContainer;

use const AlecRabbit\Cli\TERM_NOCOLOR;

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
        ?IInterval $interval = null,
    ) {
        $this->wigglerFactory =
            $wigglerFactory ?? new WigglerFactory(
                $styleRenderer,
                $frames,
                $interval
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createContainer(): IWigglerContainer
    {
        return
            new WigglerContainer(
                $this->wigglerFactory->createRevolveWiggler(),
                $this->wigglerFactory->createMessageWiggler(),
                $this->wigglerFactory->createProgressWiggler(),
            );
    }
}

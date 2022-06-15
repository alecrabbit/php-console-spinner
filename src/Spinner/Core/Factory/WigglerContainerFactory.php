<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\WigglerContainer;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class WigglerContainerFactory implements IWigglerContainerFactory
{
    private IWigglerFactory $wigglerFactory;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?IWigglerFactory $wigglerFactory = null,
        ?IFrameCollection $frames = null,
        int $terminalColorSupport = TERM_NOCOLOR,
        ?IInterval $interval = null,
    ) {
        $this->wigglerFactory =
            $wigglerFactory ?? self::defaultWigglerFactory($frames, $terminalColorSupport, $interval);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function defaultWigglerFactory(
        ?IFrameCollection $frames,
        int $terminalColorSupport,
        ?IInterval $interval
    ): IWigglerFactory {
        return
            new WigglerFactory(
                $frames,
                $terminalColorSupport,
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

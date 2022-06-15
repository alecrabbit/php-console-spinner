<?php

declare(strict_types=1);
// 09.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerContainerFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\FrameRotor;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\WIPNoStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\RainbowStyleRotor;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\RevolveWiggler;
use AlecRabbit\Spinner\Core\WigglerContainer;

final class WigglerContainerFactory implements IWigglerContainerFactory
{
    private const FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;

    private readonly IFrameCollection $frames;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?IFrameCollection $frames = null,
        private readonly ?int $terminalColorSupport = null,
        private readonly ?IInterval $interval = null,
    ) {
        $this->frames = $frames ?? self::defaultFrames();
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function defaultFrames(): IFrameCollection
    {
        return FrameCollection::create(...self::FRAME_SEQUENCE);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createContainer(): IWigglerContainer
    {
        return
            new WigglerContainer(
                $this->interval ?? $this->frames->getInterval(),
                self::createRevolveWiggler($this->frames),
                self::createMessageWiggler(),
                self::createProgressWiggler(),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createRevolveWiggler(IFrameCollection $frames): IWiggler
    {
        return
            RevolveWiggler::create(
                new RainbowStyleRotor(),
                new FrameRotor(
                    frames: $frames,
                ),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createMessageWiggler(): IWiggler
    {
        return
            MessageWiggler::create(
                new WIPNoStyleRotor(),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function createProgressWiggler(): IWiggler
    {
        return
            ProgressWiggler::create(
                new WIPNoStyleRotor(),
                new NoCharsRotor(),
            );
    }

}

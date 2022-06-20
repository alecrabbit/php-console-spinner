<?php

declare(strict_types=1);
// 15.06.22
namespace AlecRabbit\Spinner\Kernel\Factory;

use AlecRabbit\Spinner\Kernel\Contract\Base\Defaults;
use AlecRabbit\Spinner\Kernel\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Kernel\Contract\IWFrameCollection;
use AlecRabbit\Spinner\Kernel\Contract\IStyleCollection;
use AlecRabbit\Spinner\Kernel\Contract\IStyleProvider;
use AlecRabbit\Spinner\Kernel\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Kernel\WFrameCollection;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;
use AlecRabbit\Spinner\Kernel\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Kernel\Rotor\FrameRotor;
use AlecRabbit\Spinner\Kernel\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Kernel\Rotor\NoStyleRotor;
use AlecRabbit\Spinner\Kernel\Rotor\StyleRotor;
use AlecRabbit\Spinner\Kernel\StyleCollection;
use AlecRabbit\Spinner\Kernel\StyleProvider;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\RevolveWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Wiggler;

final class WigglerFactory implements IWigglerFactory
{
    private const FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;
    private IWFrameCollection $frames;
    private IStyleCollection $styles;
    private IStyleProvider $styleProvider;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        IStyleProvider $styleProvider,
        ?IWFrameCollection $frames = null,
    ) {
        $this->styleProvider = $styleProvider;
        $this->frames = $frames ?? self::defaultFrames();
        $this->styles = $this->defaultStyles();
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function defaultFrames(): IWFrameCollection
    {
        return WFrameCollection::create(...self::FRAME_SEQUENCE);
    }

    private function defaultStyles(): IStyleCollection
    {
        return
            StyleCollection::create(
                ...$this->styleProvider->provide(StylePattern::rainbow())
            );
    }

    public function createRevolveWiggler(): IWiggler
    {
        return
            RevolveWiggler::create(
                new StyleRotor($this->styles),
                new FrameRotor($this->frames,),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createMessageWiggler(): IWiggler
    {
        return
            MessageWiggler::create(
                new NoStyleRotor(),
                new NoCharsRotor(),
            );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createProgressWiggler(): IWiggler
    {
        return
            ProgressWiggler::create(
                new NoStyleRotor(),
                new NoCharsRotor(),
            );
    }

    public function createWiggler(?IStyleRotor $styleRotor = null, ?IFrameRotor $frameRotor = null): IWiggler
    {
        if (null === $styleRotor && null === $frameRotor) {
            return NullWiggler::create();
        }
        return
            Wiggler::create(
                $styleRotor ?? new NoStyleRotor(),
                $frameRotor ?? new NoCharsRotor(),
            );
    }
}

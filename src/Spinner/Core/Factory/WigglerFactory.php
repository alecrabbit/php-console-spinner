<?php

declare(strict_types=1);
// 15.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleRenderer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Rotor\Contract\IFrameRotor;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\Contract\IStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\FrameRotor;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\NoStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\StyleRotor;
use AlecRabbit\Spinner\Core\StyleCollection;
use AlecRabbit\Spinner\Core\StyleRenderer;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\RevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Wiggler;

final class WigglerFactory implements IWigglerFactory
{
    private const FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;
    private IFrameCollection $frames;
    private IStyleCollection $styles;
    private StyleRenderer $styleRenderer;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        IStyleRenderer $styleRenderer,
        ?IFrameCollection $frames = null,
    ) {
        $this->styleRenderer = $styleRenderer;
        $this->frames = $frames ?? self::defaultFrames();
        $this->styles = $this->defaultStyles();
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function defaultFrames(): IFrameCollection
    {
        return FrameCollection::create(...self::FRAME_SEQUENCE);
    }

    private function defaultStyles(): IStyleCollection
    {
        return
            StyleCollection::create(
                ...$this->styleRenderer->render(StylePattern::rainbow())
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

<?php
declare(strict_types=1);
// 15.06.22
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Base\C;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\Base\StylePattern;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\IStyleCollection;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Factory\Contract\IWigglerFactory;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Rotor\FrameRotor;
use AlecRabbit\Spinner\Core\Rotor\NoCharsRotor;
use AlecRabbit\Spinner\Core\Rotor\NoStyleRotor;
use AlecRabbit\Spinner\Core\Rotor\StyleRotor;
use AlecRabbit\Spinner\Core\StyleCollection;
use AlecRabbit\Spinner\Core\StylePatternExtractor;
use AlecRabbit\Spinner\Core\StyleRenderer;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\MessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\ProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\RevolveWiggler;

use const AlecRabbit\Cli\TERM_NOCOLOR;

final class WigglerFactory implements IWigglerFactory
{
    private IFrameCollection $frames;
    private IStyleCollection $styles;
    private StyleRenderer $styleRenderer;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        ?IFrameCollection $frames = null,
        private readonly int $terminalColorSupport = TERM_NOCOLOR,
        private readonly ?IInterval $interval = null,
    ) {
        $this->styleRenderer = new StyleRenderer(new StylePatternExtractor($this->terminalColorSupport));
        $this->frames = $frames ?? self::defaultFrames();
        $this->styles = $this->defaultStyles();
    }

    private const FRAME_SEQUENCE = Defaults::FRAME_SEQUENCE;

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

    public function createRevolveWiggler(?IFrameCollection $frames = null): IWiggler
    {
        return
            RevolveWiggler::create(
                new StyleRotor($this->styles),
                new FrameRotor(
                    frames: $frames ?? $this->frames,
                ),
            );
    }

    public function getInterval(): IInterval
    {
        return $this->interval ?? $this->frames->getInterval();
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

}

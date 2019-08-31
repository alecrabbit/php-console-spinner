<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Coloring\Style;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Settings;

class FrameJuggler extends AbstractJuggler
{
    /** @var Circular */
    protected $frames;

    public function __construct(Settings $settings, Style $style)
    {
        $frames = $settings->getFrames();
        $this->assertFrames($frames);
        $this->frames = new Circular($frames);
        $this->init($style);
        $this->currentFrameErasingLength =
            Calculator::computeErasingLength($frames) + strlen($this->spacer) + $this->formatErasingShift;
    }

    /**
     * @param array $frames
     */
    protected function assertFrames(array $frames): void
    {
        if (Defaults::MAX_FRAMES_COUNT < $count = count($frames)) {
            throw new \InvalidArgumentException(
                sprintf('Frames count limit [%s] exceeded: [%s].', Defaults::MAX_FRAMES_COUNT, $count)
            );
        }
        foreach ($frames as $frame) {
            $this->assertFrame($frame);
        }
    }

    /**
     * @param mixed $frame
     */
    protected function assertFrame($frame): void
    {
        if (!\is_string($frame)) {
            throw new \InvalidArgumentException('All frames should be of string type.');
        }
        if (Defaults::MAX_FRAME_LENGTH < $length = mb_strlen($frame)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Single frame max length [%s] exceeded [%s]',
                    Defaults::MAX_FRAME_LENGTH,
                    $length
                )
            );
        }
    }

    /**
     * @return string
     */
    protected function getCurrentFrame(): string
    {
        return $this->frames->value();
    }
}

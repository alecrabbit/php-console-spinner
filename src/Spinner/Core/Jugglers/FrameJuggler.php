<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\Calculator;
use AlecRabbit\Spinner\Core\Jugglers\Contracts\JugglerInterface;
use AlecRabbit\Spinner\Settings\Contracts\Defaults;

class FrameJuggler implements JugglerInterface
{
    /** @var Circular */
    protected $frames;
    /** @var int */
    protected $erasingLength;
    /** @var string */
    protected $spacer = Defaults::ONE_SPACE_SYMBOL;

    public function __construct(array $frames)
    {
        $this->assertFrames($frames);
        $this->frames = new Circular($frames);
        $this->erasingLength = Calculator::computeErasingLength($frames) + strlen($this->spacer);
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

    /** {@inheritDoc} */
    public function getFrame(): string
    {
        return (string)$this->frames->value() . $this->spacer;
    }

    /** {@inheritDoc} */
    public function getFrameErasingLength(): int
    {
        return $this->erasingLength;
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
}

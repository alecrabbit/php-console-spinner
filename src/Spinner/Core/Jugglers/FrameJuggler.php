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

    public function __construct(array $frames)
    {
        $this->assertFrames($frames);
        $this->frames = new Circular($frames);
        $this->erasingLength = Calculator::computeErasingLen($frames);
    }

    protected function assertFrames(array $frames): void
    {
        if ( Defaults::MAX_FRAMES_COUNT < $count = count($frames)) {
            throw new \InvalidArgumentException(
                sprintf('Frames count limit [%s] exceeded: [%s].', Defaults::MAX_FRAMES_COUNT, $count)
            );
        }
        foreach ($frames as $frame) {
            if (!\is_string($frame)) {
                throw new \InvalidArgumentException('All frames should be of string type.');
            }
            if (mb_strlen($frame) > Defaults::MAX_FRAME_LENGTH) {
                throw new \InvalidArgumentException(sprintf(
                    'Frames should NOT exceed max length [%s].',
                    Defaults::MAX_FRAME_LENGTH
                ));
            }
        }
    }

    /**
     * @return string
     */
    public function getFrame(): string
    {
        return $this->frames->value();
    }
    public function getFrameErasingLength(): int
    {
        return $this->erasingLength;
    }


}
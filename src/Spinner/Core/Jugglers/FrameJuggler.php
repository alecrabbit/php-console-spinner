<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Jugglers;

class FrameJuggler
{
    /** @var array */
    protected $frames;

    public function __construct(array $frames)
    {
        $this->frames = $frames;
    }

}
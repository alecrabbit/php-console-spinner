<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

final class Frame
{
    private const CHARS = ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    private int $currentCharIdx = 0;
    private int $frameCount;

    public function __construct()
    {
        $this->frameCount = count(self::CHARS);
    }

    public function next(): string
    {
        if (++$this->currentCharIdx === $this->frameCount) {
            $this->currentCharIdx = 0;
        }
        return (string)self::CHARS[$this->currentCharIdx];
    }

}

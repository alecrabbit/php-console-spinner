<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class ACharRotor
{
    protected const CHARS = [];
    protected const CHAR_WIDTH = 0;
    protected int $currentCharIdx = 0;
    protected int $frameCount;

    public function __construct()
    {
        $this->frameCount = count(self::CHARS);
    }

    public function next(): string
    {
        if (0 === $this->frameCount) {
            return '';
        }

        if (++$this->currentCharIdx === $this->frameCount) {
            $this->currentCharIdx = 0;
        }
        return (string)self::CHARS[$this->currentCharIdx];
    }

    public function getWidth(): int
    {
        return self::CHAR_WIDTH;
    }

}

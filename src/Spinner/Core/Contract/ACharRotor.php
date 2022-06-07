<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class ACharRotor extends ARotor
{
    protected const CHARS = [];
    protected const CHAR_WIDTH = 0;
    protected int $currentCharIdx = 0;
    protected int $frameCount;

    public function __construct()
    {
        $this->frameCount = count(static::CHARS);
    }

    public function next(float|int|null $interval = null): string
    {
        if (0 === $this->frameCount) {
            return '';
        }

        if (++$this->currentCharIdx === $this->frameCount) {
            $this->currentCharIdx = 0;
        }
        return (string)static::CHARS[$this->currentCharIdx];
    }

    public function getWidth(): int
    {
        return static::CHAR_WIDTH;
    }

}

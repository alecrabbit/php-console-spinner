<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class AColorRotor
{
    protected const COLORS = [];

    protected int $currentColorIdx = 0;
    protected int $colorLen;

    public function __construct()
    {
        $this->colorLen = count(static::COLORS);
    }

    public function next(): string
    {
        if (0 === $this->colorLen) {
            return '';
        }
        if (++$this->currentColorIdx === $this->colorLen) {
            $this->currentColorIdx = 0;
        }
        return (string)static::COLORS[$this->currentColorIdx];
    }

}

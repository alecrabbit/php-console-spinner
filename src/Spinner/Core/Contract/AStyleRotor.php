<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class AStyleRotor
{
    protected const STYLES = [];

    protected int $currentStyleIdx = 0;
    protected readonly int $stylesLength;

    public function __construct()
    {
        $this->stylesLength = count(static::STYLES);
    }

    public function next(float|int|null $interval = null): string
    {
        if (0 === $this->stylesLength) {
            return '';
        }
        if (++$this->currentStyleIdx === $this->stylesLength) {
            $this->currentStyleIdx = 0;
        }
        return (string)static::STYLES[$this->currentStyleIdx];
    }

}

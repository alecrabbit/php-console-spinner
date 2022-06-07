<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class AStyleRotor extends ARotor
{
    protected const STYLES = [];

    protected int $currentStyleIdx = 0;
    protected readonly int $stylesLength;

    public function __construct(
        protected readonly ?int $colorSupportLevel = null,
        protected readonly string $leadingSpacer = '',
        protected readonly string $trailingSpacer = '',
    ) {
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
        return $this->nextStyle($interval);
    }

    protected function nextStyle(float|int|null $interval = null): string
    {
        return (string)static::STYLES[$this->currentStyleIdx];
    }

}

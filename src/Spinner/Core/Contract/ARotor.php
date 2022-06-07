<?php
declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Contract;

abstract class ARotor implements IRotor
{
    protected const DATA = [];
    protected int $currentIndex = 0;
    protected readonly int $dataLength;

    public function __construct()
    {
        $this->dataLength = count(static::DATA);
    }

    public function next(float|int|null $interval = null): string
    {
        if (0 === $this->dataLength) {
            return '';
        }
        if (++$this->currentIndex === $this->dataLength) {
            $this->currentIndex = 0;
        }
        return $this->nextElement($interval);
    }

    protected function nextElement(float|int|null $interval = null): string
    {
        return (string)static::DATA[$this->currentIndex];
    }
}

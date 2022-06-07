<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

abstract class ACharRotor extends ARotor implements ICharRotor
{
    protected const ELEMENT_WIDTH = 0;

    public function getWidth(): int
    {
        return static::ELEMENT_WIDTH;
    }

}

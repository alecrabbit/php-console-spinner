<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler;

use AlecRabbit\Spinner\Kernel\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Kernel\Exception\RuntimeException;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;

final class Wiggler extends AWiggler
{
    protected static function assertWiggler(IWiggler|string|null $wiggler): void
    {
    }


    /**
     * @throws InvalidArgumentException
     * @deprecated
     */
    public function update(IWiggler|string|null $wiggler): IWiggler
    {
        // TODO: Implement update() method.
    }
}

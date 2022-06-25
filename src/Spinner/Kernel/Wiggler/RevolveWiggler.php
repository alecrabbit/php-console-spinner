<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Wiggler;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IWiggler;

final class RevolveWiggler extends AWiggler implements IRevolveWiggler
{
    protected static function assertWiggler(IWiggler|string|null $wiggler): void
    {
        if (null === $wiggler || is_string($wiggler) || $wiggler instanceof IRevolveWiggler) {
            return;
        }
        throw new RuntimeException(
            'Message variable must be a string, null or an instance of IRevolveWiggler'
        );
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

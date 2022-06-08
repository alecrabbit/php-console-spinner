<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

final class RevolveWiggler extends AWiggler implements IRevolveWiggler
{
    public function update(IWiggler|string|float|null $wiggler): IWiggler
    {
        // TODO: Implement update() method.
    }

    protected static function assertWiggler(float|IWiggler|string|null $wiggler): void
    {
        if (null === $wiggler || is_string($wiggler) || $wiggler instanceof IRevolveWiggler) {
            return;
        }
        throw new RuntimeException(
            'Message variable must be a string, null or an instance of IRevolveWiggler'
        );
    }
}

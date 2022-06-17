<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\RuntimeException;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

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

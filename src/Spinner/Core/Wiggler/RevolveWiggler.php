<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\IRevolveWiggler;
use AlecRabbit\Spinner\Core\Contract\IWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class RevolveWiggler extends AWiggler implements IRevolveWiggler
{
    public function update(IWiggler|string|null $message): IWiggler
    {
        // TODO: Implement update() method.
    }
}

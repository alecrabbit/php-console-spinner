<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IWiggler;

final class ProgressWiggler extends AWiggler implements IProgressWiggler
{
    protected function createSequence(float|int|null $interval = null): string
    {
        return '';
    }

    public function update(IWiggler|string|null $wiggler): IWiggler
    {
        // TODO: Implement update() method.
    }
}

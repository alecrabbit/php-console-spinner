<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class ProgressWiggler extends AWiggler implements IProgressWiggler
{
    protected function getSequence(float|int|null $interval = null): string
    {
        return '';
    }
}

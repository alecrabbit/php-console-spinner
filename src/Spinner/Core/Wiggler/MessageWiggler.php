<?php
declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Wiggler;

use AlecRabbit\Spinner\Core\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\AWiggler;

final class MessageWiggler extends AWiggler implements IMessageWiggler
{
    protected function getSequence(float|int|null $interval = null): string
    {
        return '';
    }
}

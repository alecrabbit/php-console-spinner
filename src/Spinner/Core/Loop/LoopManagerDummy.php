<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopManager;
use AlecRabbit\Spinner\Exception\DomainException;

final class LoopManagerDummy implements ILoopManager
{
    public function createLoop(): ILoopAdapter
    {
        throw new DomainException(
            sprintf(
                'Class [%s] is not supposed to return any loop.%s',
                __CLASS__,
                ' Check your configuration.'
            )
        );
    }
}

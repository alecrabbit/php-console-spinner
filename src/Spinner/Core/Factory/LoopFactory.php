<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class LoopFactory implements ILoopFactory
{
    public function create(): ILoop
    {
        // TODO: Implement create() method.
        throw new \RuntimeException('Not implemented.');
    }
}

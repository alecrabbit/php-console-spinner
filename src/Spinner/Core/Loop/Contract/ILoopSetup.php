<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

interface ILoopSetup
{
    public function setup(ILoop $loop): void;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

interface ILoopSetup
{
    public function setup(ILoop $loop): void;
}

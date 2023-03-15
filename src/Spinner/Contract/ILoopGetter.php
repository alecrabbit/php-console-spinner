<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Contract;

use React\EventLoop\LoopInterface;
use Revolt\EventLoop\Driver;

interface ILoopGetter
{
    public function getLoop(): LoopInterface|Driver;
}

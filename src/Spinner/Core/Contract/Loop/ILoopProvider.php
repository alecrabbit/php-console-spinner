<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract\Loop;

interface ILoopProvider
{
    public function getLoop(): ILoop;
}

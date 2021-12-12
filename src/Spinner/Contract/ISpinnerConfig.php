<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISpinnerConfig
{
    public function getOutput(): IOutput;

    public function getLoop(): ILoop;
}

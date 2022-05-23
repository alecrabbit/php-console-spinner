<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IWiggler
{
    public function getFrame(float|int|null $interval = null): IFrame;
}

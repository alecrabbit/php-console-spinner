<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Core\Wiggler\Contract\IRevolveWiggler;

interface ISimpleSpinner extends IBaseSpinner
{
    public function spinner(IRevolveWiggler|string|null $wiggler): void;

    public function message(IMessageWiggler|string|null $wiggler): void;

    public function progress(IProgressWiggler|float|null $wiggler): void;
}

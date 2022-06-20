<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IMessageWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IProgressWiggler;
use AlecRabbit\Spinner\Kernel\Wiggler\Contract\IRevolveWiggler;

interface IWSimpleSpinner
{
    public function spinner(IRevolveWiggler|string|null $wiggler): void;

    public function message(IMessageWiggler|string|null $wiggler): void;

    public function progress(IProgressWiggler|float|null $wiggler): void;
}

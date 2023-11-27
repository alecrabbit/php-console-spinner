<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IFinalizable;
use AlecRabbit\Spinner\Contract\IInitializable;

interface IRenderer extends IInitializable, IFinalizable
{
    public function render(ISpinner $spinner, ?float $dt = null): void;

    public function erase(ISpinner $spinner): void;
}

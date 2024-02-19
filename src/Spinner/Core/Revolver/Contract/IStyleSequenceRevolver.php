<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\IStyleSequenceFrame;

interface IStyleSequenceRevolver extends IRevolver
{
    public function getFrame(?float $dt = null): IStyleSequenceFrame;
}

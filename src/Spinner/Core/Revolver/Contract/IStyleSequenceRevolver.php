<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;

interface IStyleSequenceRevolver extends IRevolver, IHasStyleSequenceFrame
{
    public function getFrame(?float $dt = null): IStyleSequenceFrame;
}

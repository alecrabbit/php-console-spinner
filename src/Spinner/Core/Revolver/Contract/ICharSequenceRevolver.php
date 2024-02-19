<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;

interface ICharSequenceRevolver extends IRevolver, IHasCharSequenceFrame
{
    public function getFrame(?float $dt = null): ICharSequenceFrame;
}

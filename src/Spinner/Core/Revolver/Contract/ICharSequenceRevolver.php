<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Contract\ICharSequenceFrame;

interface ICharSequenceRevolver extends IRevolver
{
    public function getFrame(?float $dt = null): ICharSequenceFrame;
}

<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\ICharSequenceRevolver;

final class CharSequenceRevolver extends ARevolver implements ICharSequenceRevolver
{
    public function __construct(
        protected IHasCharSequenceFrame $frames,
        IInterval $interval,
    ) {
        parent::__construct($interval);
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
    {
        return $this->frames->getFrame($dt);
    }
}

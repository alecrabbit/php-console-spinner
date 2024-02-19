<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IStyleSequenceRevolver;

final class StyleSequenceRevolver extends ARevolver implements IStyleSequenceRevolver
{
    public function __construct(
        private readonly IHasStyleSequenceFrame $frames,
        IInterval $interval,
    ) {
        parent::__construct($interval);
    }

    public function getFrame(?float $dt = null): IStyleSequenceFrame
    {
        return $this->frames->getFrame($dt);
    }
}

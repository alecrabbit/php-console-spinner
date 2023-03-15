<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\I\IFrame;
use AlecRabbit\Spinner\I\IProcedure;

abstract class AProcedure implements IProcedure
{
    /**
     * @inheritdoc
     */
    abstract public function update(float $dt = null): IFrame;
}

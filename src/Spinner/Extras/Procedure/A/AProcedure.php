<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IProcedure;

abstract class AProcedure implements IProcedure
{
    /**
     * @inheritdoc
     */
    abstract public function update(float $dt = null): IFrame;
}

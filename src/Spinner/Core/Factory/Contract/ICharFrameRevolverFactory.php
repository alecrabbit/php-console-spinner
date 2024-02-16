<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;

interface ICharFrameRevolverFactory extends IFrameRevolverFactory
{
    /**
     * @deprecated
     */
    public function legacyCreate(IPattern $pattern): IFrameRevolver;
}

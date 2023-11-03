<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use Traversable;

interface ISignalHandlersContainer
{
    /**
     * @return Traversable<int, IHandlerCreator>
     */
    public function getHandlerCreators(): Traversable;
}

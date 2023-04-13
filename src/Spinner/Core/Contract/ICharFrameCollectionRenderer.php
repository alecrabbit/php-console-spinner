<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ICharFrameCollectionRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IPattern $pattern): IFrameCollection;
}

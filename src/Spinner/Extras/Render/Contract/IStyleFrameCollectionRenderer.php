<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Render\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameCollectionRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IStylePattern $pattern): IFrameCollection;
}

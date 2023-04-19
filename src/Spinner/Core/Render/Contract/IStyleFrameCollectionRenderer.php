<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Render\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStyleLegacyPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IStyleFrameCollectionRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(IStyleLegacyPattern $pattern): IFrameCollection;
}

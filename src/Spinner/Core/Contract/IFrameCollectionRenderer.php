<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IFrameCollectionRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function pattern(IPattern $pattern): IFrameCollectionRenderer;

    /**
     * @throws InvalidArgumentException
     */
    public function render(): IFrameCollection;
}

<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IFrameRenderer
{
    /**
     * @throws InvalidArgumentException
     */
    public function render(): IFrameCollection;
}
